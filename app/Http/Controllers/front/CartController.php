<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\DealCategory;
use App\Models\Sides;
use App\Models\TopDeals;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Item;
use App\Models\ProductSizeCrust;
use App\Models\PizzaPrice;
use App\Helpers\helper;
use App\Services\BogoAutoAddService;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DealItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\log;

class CartController extends Controller
{
    /**
     * Scope a cart query to the current logged-in user or guest session.
     */
    private function buildCartOwnerQuery()
    {
        return Auth::user() && Auth::user()->type == 2
            ? Cart::where('user_id', Auth::user()->id)
            : Cart::where('session_id', Session::getId());
    }

    private function normalizeMatchValue($value)
    {
        return ($value === null || $value === '') ? null : $value;
    }

    /**
     * Find all cart lines belonging to the current user/session that represent
     * the exact same product configuration (item, deal slot, size/crust,
     * addons/extras, dippings) as the given criteria.
     */
    private function findMatchingCartLines(array $criteria)
    {
        $query = $this->buildCartOwnerQuery()
            ->where('item_id', $criteria['item_id'])
            ->where('buynow', (int) ($criteria['buynow'] ?? 0));

        foreach (['deal_id', 'deal_category_id', 'size_id', 'crust_id', 'addons_id', 'extras_id', 'dipping_name'] as $field) {
            $value = $this->normalizeMatchValue($criteria[$field] ?? null);
            if ($value === null) {
                $query->where(function ($q) use ($field) {
                    $q->whereNull($field)->orWhere($field, '');
                });
            } else {
                $query->where($field, $value);
            }
        }

        return $query->get();
    }

    private function findMatchingCartLine(array $criteria)
    {
        return $this->findMatchingCartLines($criteria)->first();
    }

    /**
     * Remove up to $qtyToRemove of a specific item from the given deal categories
     * (oldest cart lines first), deleting lines that are fully consumed and
     * decrementing the last partially-consumed line. Returns the quantity actually
     * removed.
     *
     * Used to keep paid/free pairs of the SAME product in a "buy X get X free"
     * deal in sync: whichever side (paid or free) a user removes first, the
     * matching quantity of the other side is auto-removed too, instead of
     * leaving a leftover line that ends up mismatched with a different product.
     */
    private function cascadeRemoveDealItem(TopDeals $deal, $categoryIds, $itemId, int $qtyToRemove): int
    {
        $categoryIds = collect($categoryIds)->filter()->values();

        if ($qtyToRemove <= 0 || $categoryIds->isEmpty()) {
            return 0;
        }

        $lines = $this->buildCartOwnerQuery()
            ->where('deal_id', $deal->id)
            ->where('item_id', $itemId)
            ->whereIn('deal_category_id', $categoryIds)
            ->orderBy('id')
            ->get();

        $removed = 0;
        $remaining = $qtyToRemove;

        foreach ($lines as $line) {
            if ($remaining <= 0) {
                break;
            }
            if ($line->qty <= $remaining) {
                $removed += $line->qty;
                $remaining -= $line->qty;
                $line->delete();
            } else {
                $line->qty -= $remaining;
                $line->save();
                $removed += $remaining;
                $remaining = 0;
            }
        }

        return $removed;
    }

    /**
     * Delete a deal-linked cart line for a "Buy X get Y free" (deal_type 3) deal.
     *
     * - Deleting a free line cascades to auto-remove the same quantity of the
     *   matching paid (required) line for the SAME item_id, so a paid item never
     *   lingers mismatched with some other product's free item.
     * - Deleting a required line that would orphan free items first tries the
     *   same cascade in reverse (auto-remove the matching free item for the SAME
     *   item_id). Only if that can't fully resolve it (e.g. the excess free
     *   items belong to a different product) does it fall back to blocking the
     *   delete and asking the user to remove the free item(s) first.
     *
     * @return array{ok: bool, message?: string}
     */
    private function deleteDealCartLine(Cart $checkcart, $cartQuery): array
    {
        $deal = TopDeals::find($checkcart->deal_id);
        if (!$deal || $deal->deal_type != 3) {
            $checkcart->delete();
            session()->forget('discount_data');
            return ['ok' => true];
        }

        $matchingLines = $this->findMatchingCartLines([
            'item_id' => $checkcart->item_id,
            'deal_id' => $checkcart->deal_id,
            'deal_category_id' => $checkcart->deal_category_id,
            'size_id' => $checkcart->size_id,
            'crust_id' => $checkcart->crust_id,
            'addons_id' => $checkcart->addons_id,
            'extras_id' => $checkcart->extras_id,
            'dipping_name' => $checkcart->dipping_name,
            'buynow' => $checkcart->buynow,
        ]);
        $combinedQty = $matchingLines->sum('qty');

        log::info('deleteDealCartLine: matching sibling lines for deal item', [
            'cart_id' => $checkcart->id,
            'sibling_ids' => $matchingLines->pluck('id')->all(),
            'combined_qty' => $combinedQty,
        ]);

        $dealCategory = DealCategory::find($checkcart->deal_category_id);

        // Free item → allow delete, and cascade-remove the paid counterpart
        // (same item_id, same deal) so it doesn't linger mismatched with a
        // different product's free item once its own free pair is gone.
        if ($dealCategory && $dealCategory->is_free) {
            foreach ($matchingLines as $line) {
                $line->delete();
            }

            $requiredCategoryIds = DealCategory::where('deal_id', $deal->id)
                ->where('is_required', true)
                ->pluck('id');
            $this->cascadeRemoveDealItem($deal, $requiredCategoryIds, $checkcart->item_id, $combinedQty);

            session()->forget('discount_data');
            return ['ok' => true];
        }

        // Required item — need to check validation
        $dealCategories = DealCategory::where('deal_id', $deal->id)->get();
        $requiredCategory = $dealCategories->firstWhere('id', $checkcart->deal_category_id);

        if (!$requiredCategory || !$requiredCategory->is_required) {
            foreach ($matchingLines as $line) {
                $line->delete();
            }
            session()->forget('discount_data');
            return ['ok' => true];
        }

        // STEP 1: Calculate current sets BEFORE deletion
        $requiredItemIds = DealItem::where('deal_category_id', $requiredCategory->id)->pluck('item_id');
        $currentRequiredQty = (clone $cartQuery)
            ->whereIn('item_id', $requiredItemIds)->where('deal_id', $deal->id)->where('deal_category_id', $requiredCategory->id)
            ->sum('qty');

        $currentSets = intdiv($currentRequiredQty, $requiredCategory->quantity);

        // STEP 2: Calculate sets AFTER deletion (removing all matching sibling lines together)
        $requiredQtyAfterDeletion = $currentRequiredQty - $combinedQty;
        $setsAfterDeletion = intdiv(max(0, $requiredQtyAfterDeletion), $requiredCategory->quantity);
        // If sets don't change, safe to delete
        if ($setsAfterDeletion >= $currentSets) {
            foreach ($matchingLines as $line) {
                $line->delete();
            }
            session()->forget('discount_data');
            return ['ok' => true];
        }

        // STEP 3: Sets are reduced - check if we have excess free items
        $freeCategories = $dealCategories->where('is_free', true);

        foreach ($freeCategories as $freeCategory) {
            $freeItemIds = DealItem::where('deal_category_id', $freeCategory->id)->pluck('item_id');

            $currentFreeQty = (clone $cartQuery)
                ->whereIn('item_id', $freeItemIds)->where('deal_id', $deal->id)->where('deal_category_id', $freeCategory->id)
                ->sum('qty');

            // Calculate how many free items are allowed based on current sets vs after deletion
            $allowedFreeAfterDeletion = $setsAfterDeletion * $freeCategory->quantity;

            // If we have more free items than will be allowed after deletion, first
            // try auto-removing the matching free item for the SAME product.
            if ($currentFreeQty > $allowedFreeAfterDeletion) {
                $excessFreeItems = $currentFreeQty - $allowedFreeAfterDeletion;

                $excessFreeItems -= $this->cascadeRemoveDealItem($deal, [$freeCategory->id], $checkcart->item_id, $excessFreeItems);

                // Backup: the cascade couldn't fully resolve it (the excess free
                // items belong to a different product) — block and notify instead.
                if ($excessFreeItems > 0) {
                    log::info('deleteDealCartLine: blocked, would orphan free items', [
                        'cart_id' => $checkcart->id,
                        'excess_free_items' => $excessFreeItems,
                    ]);
                    return [
                        'ok' => false,
                        'message' => "You cannot delete this required item. You have {$excessFreeItems} free item(s) that depend on it. Please remove the free items first.",
                    ];
                }
            }
        }

        // ✅ Passed validation — allow deletion of this line and its duplicates
        foreach ($matchingLines as $line) {
            $line->delete();
        }
        session()->forget('discount_data');
        return ['ok' => true];
    }

    public function index(Request $request)
    {
        if (Auth::user() && Auth::user()->type == 2) {
            $getcartlist = Cart::where('user_id', Auth::user()->id)->orderByDesc('id')->get();
        } else {
            $getcartlist = Cart::where('session_id', Session::getId())->orderByDesc('id')->get();
        }

        $getsettings = Settings::first();
        $itemtaxes = [];
        $producttax = 0;
        $tax_name = [];
        $tax_price = [];


        foreach ($getcartlist as $cart) {
            $taxlist =  helper::gettax($cart->tax);
            if (!empty($taxlist)) {
                foreach ($taxlist as $tax) {
                    if (!empty($tax)) {
                        if (!in_array($tax->name, $tax_name)) {
                            $tax_name[] = $tax->name;

                            if ($tax->type == 1) {
                                $price = $tax->tax * $cart->qty;
                            }

                            if ($tax->type == 2) {
                                $price = ($tax->tax / 100) * ($cart->addons_total_price + $cart->item_price) * $cart->qty;
                            }
                            $tax_price[] = $price;
                        } else {
                            if ($tax->type == 1) {
                                $price = $tax->tax * $cart->qty;
                            }

                            if ($tax->type == 2) {
                                $price = ($tax->tax / 100) * ($cart->addons_total_price + $cart->item_price) * $cart->qty;
                            }
                            $tax_price[array_search($tax->name, $tax_name)] += $price;
                        }
                    }
                }
            }
        }

        $discount = helper::calculateDiscount($getcartlist);
        $taxArr['tax'] = $tax_name;
        $taxArr['rate'] = $tax_price;
        return view('web.cart.cart', compact('getcartlist', 'getsettings', 'taxArr',  'discount'));
    }
    public function addtocart(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|exists:item,slug',
            'deal_id' => 'nullable|exists:top_deals,id',
            'deal_category_id' => 'nullable|exists:deal_categories,id',
            'size_id' => 'nullable|exists:sizes,id',
            'crust_id' => 'nullable|exists:crusts,id',
            'qty' => 'nullable|integer|min:1',
        ]);
        $branchId = Session::get('branch_id');

        try {
            if ($request->buynow == 1) {
                if (Auth::user() && Auth::user()->type == 2) {
                    log::info('user_id', ['user_id' => Auth::user()->id]);
                    Cart::where('buynow', 1)->where('user_id', Auth::user()->id)->delete();
                } else {
                    log::info('session_id', ['session_id' => Session::getId()]);
                    Cart::where('buynow', 1)->where('session_id', Session::getId())->delete();
                }
            }
            $itemdata = Item::where('slug', $validated['slug'])->select('item.*',
                DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"))
                ->leftJoin('item_prices', function ($query) use ($branchId) {
                    $query->on('item_prices.item_id', '=', 'item.id')
                        ->where('item_prices.branch_id', '=', $branchId);
                })->first();

            $serverItemPrice = $itemdata->item_price;

            if ($request->filled('size_id') && $request->filled('crust_id')) {
                $pizzaBasePrice = PizzaPrice::where('item_id', $itemdata->id)
                    ->where('branch_id', $branchId)
                    ->where('size_id', $request->size_id)
                    ->value('price');

                $sizeCrustPrice = ProductSizeCrust::where('item_id', $itemdata->id)
                    ->where('size_id', $request->size_id)
                    ->where('crust_id', $request->crust_id)
                    ->value('price');

                if ($pizzaBasePrice === null || $sizeCrustPrice === null) {
                    return response()->json([
                        'status' => 0,
                        'message' => 'Selected size/crust combination is not available for this item.',
                        'buynow' => $request->buynow
                    ], 200);
                }

                $serverItemPrice = $pizzaBasePrice + $sizeCrustPrice;
            }

            if ($request->deal_id) {
                $deal = TopDeals::where('id', $request->deal_id)->first();

                if ($deal && $deal->deal_type == 3) {
                    // Load the current deal_category row
                    $dealCategory = DealCategory::with('dealItem')
                        ->where('id', $request->deal_category_id)
                        ->first();

                    if (!$dealCategory) {
                        return response()->json([
                            'status' => 0,
                            'message' => 'Invalid deal category.',
                            'buynow' => $request->buynow
                        ], 200);
                    }

                    // Base cart query
                    $cartQuery = Auth::check() && Auth::user()->type == 2
                        ? Cart::where('user_id', Auth::id())
                        : Cart::where('session_id', Session::getId());

                    // Load *all* deal categories for this deal
                    $dealCategories = DealCategory::where('deal_id', $request->deal_id)
                        ->with('dealItem')
                        ->get();

                    $totalEligibleSets = null;
                    $freeLimits = []; // category_id => max allowed per category
                    $totalFreeItemsPerSet = 0;

                    // Gather logic across required/free categories
                    foreach ($dealCategories as $category) {
                        $itemIds = $category->dealItem->pluck('item_id');
                        $cartQty = (clone $cartQuery)
                            ->whereIn('item_id', $itemIds)
                            ->where('deal_category_id', $category->id) // ✅ restrict per category record
                            ->sum('qty');

                        if ($category->is_free === 1) {
                            $freeLimits[$category->id] = $category->quantity;
                        } else {
                            $requiredQty = $category->quantity;
                            $sets = intdiv($cartQty, $requiredQty);

                            $totalEligibleSets = is_null($totalEligibleSets)
                                ? $sets
                                : min($totalEligibleSets, $sets);
                        }
                    }

                    $requestedQty = $request->qty ?? 1;

                    // ✅ Work off the specific deal_category being added
                    if ($dealCategory->is_free) {
                        // Must check base requirement first
                        if ($totalEligibleSets < 1) {
                            return response()->json([
                                'status' => 0,
                                'message' => 'Please add the required items to unlock discounted items in this deal.',
                                'buynow' => $request->buynow
                            ], 200);
                        }

                        // dd($totalEligibleSets, $freeLimits[$dealCategory->id]);
                        // Calculate allowed discounted items for this deal
                        $maxDiscountedAllowed = $totalEligibleSets * ($freeLimits[$dealCategory->id] ?? 0);


                        $existingDiscountedQty = (clone $cartQuery)
                            ->where('deal_id', $deal->id)
                            ->where('deal_category_id', $dealCategory->id) // check across all free categories
                            ->sum('qty');



                        if ($existingDiscountedQty + $requestedQty <= $maxDiscountedAllowed) {
                            $serverItemPrice = 0;
                            $request->merge(['is_discounted' => true]);
                        } else {
                            return response()->json([
                                'status' => 0,
                                'message' => 'You have already added the maximum allowed discounted items for this deal. Add more base items to unlock more.',
                                'buynow' => $request->buynow
                            ], 200);
                        }
                    }
                    // else → required category, just use normal price
                }

            }


            $requestQty = (int) ($request->qty ?: 1);
            $matchCriteria = [
                'item_id' => $itemdata->id,
                'deal_id' => $request->deal_id ?? null,
                'deal_category_id' => $request->deal_category_id ?? null,
                'size_id' => $request->size_id ?? null,
                'crust_id' => $request->crust_id ?? null,
                'addons_id' => $request->addons_id ?? null,
                'extras_id' => $request->extras_id ?? null,
                'dipping_name' => null,
                'buynow' => (int) ($request->buynow ?? 0),
            ];

            $existingLine = $this->findMatchingCartLine($matchCriteria);

            if ($existingLine) {
                log::info('addtocart: matching cart line found, merging qty instead of creating new row', [
                    'cart_id' => $existingLine->id,
                    'old_qty' => $existingLine->qty,
                    'added_qty' => $requestQty,
                    'criteria' => $matchCriteria,
                ]);
                $existingLine->qty += $requestQty;
                $existingLine->save();
                $cart = $existingLine;
            } else {
                log::info('addtocart: no matching cart line found, creating new row', [
                    'criteria' => $matchCriteria,
                ]);
                $cart = new Cart();
                if (Auth::user() && Auth::user()->type == 2) {
                    $cart->user_id = Auth::user()->id;
                    $cart->session_id = "";
                } else {
                    $cart->user_id = "";
                    $cart->session_id = Session::getId();
                }
                $cart->item_id = $itemdata->id;
                $cart->deal_id = $request->deal_id ?? null;
                $cart->item_name = $request->item_name;
                $cart->item_type = $request->item_type;
                $cart->item_image = $request->image_name;
                $cart->size_id = $request->size_id;
                $cart->crust_id = $request->crust_id;
                $cart->deal_category_id = $request->deal_category_id ?? null;
                $cart->tax = $request->tax;
                $cart->item_price = helper::number_format($serverItemPrice);
                $cart->addons_id = $request->addons_id == null ? null : $request->addons_id;
                $cart->addons_name = $request->addons_name == null ? null : $request->addons_name;
                $cart->addons_price = $request->addons_price == null ? null : $request->addons_price;
                $cart->addons_total_price = helper::number_format($request->addons_price == "" ? 0 : array_sum(explode('| ', $request->addons_price)));
                $cart->extras_id = $request->extras_id == null ? null : $request->extras_id;
                $cart->extras_name = $request->extras_name == null ? null : $request->extras_name;
                $cart->extras_price = $request->extras_price == null ? null : $request->extras_price;
                $cart->extras_total_price = helper::number_format($request->extras_price == "" ? 0 : array_sum(explode('| ', $request->extras_price)));
                $cart->qty = $requestQty;
                $cart->buynow = $request->buynow;
                $cart->save();
                log::info('addtocart: new cart row created', ['cart_id' => $cart->id]);
            }

            $autoAddedItems = BogoAutoAddService::autoAddFreeItems($cart);

            if (Auth::user() && Auth::user()->type == 2) {
                $total_count = Cart::where('user_id', Auth::user()->id)->where('buynow', 0)->count();
            } else {
                $oldsessionid = Session::getId();
                Session::put('oldsessionid', $oldsessionid);
                $total_count = Cart::where('session_id', Session::getId())->where('buynow', 0)->count();
            }
            session()->forget('discount_data');
            helper::startCartTimer();
            return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $total_count, 'total_item_count' => helper::get_item_cart($itemdata->id), 'buynow' => $request->buynow], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong'),'error' => $th->getMessage(), 'buynow' => $request->buynow], 200);
        }
    }

    public function addpizzatocart(Request $request)
    {
        log::info('no i am hit');

        $validated = $request->validate([
            'slug' => 'required|string|exists:item,slug',
            'size_id' => 'required|integer|exists:sizes,id',
            'crust_id' => 'required|integer|exists:crusts,id',
            'qty' => 'required|integer|min:1',
        ]);
        try {
            if ($request->buynow == 1) {
                if (Auth::user() && Auth::user()->type == 2) {
                    Cart::where('buynow', 1)->where('user_id', Auth::user()->id)->delete();
                } else {
                    Cart::where('buynow', 1)->where('session_id', Session::getId())->delete();
                }
            }
            $addonIds = $request->addons_id;
            $dippings = $request->dippings;

            if ($addonIds !== null) {
                // Split the addonIds by '|' into an array
                $addonIdsArray = explode('|', $addonIds);

                // Fetch the addon names for these IDs in the same order
                $addonNames = DB::table('addons')
                    ->whereIn('id', $addonIdsArray)
                    ->orderByRaw('FIELD(id, ' . implode(',', $addonIdsArray) . ')') // Maintain order
                    ->pluck('name');

                // Join the addon names back into a '|' separated string
                $addonsNameString = $addonNames->implode('| ');

                // Assign the formatted names to a variable
                $addons_name = $addonsNameString;
            } else {
                $addons_name = null;
            }

            if ($dippings !== null) {
                // Initialize variables to store concatenated values
                $dippingName = [];
                $dippingPrice = [];
                $dippingQuantity = [];

                // Loop through each dipping and process
                foreach ($dippings as $dipping) {
                    $side = Sides::find($dipping['id']);
                    if ($side) {
                        $dippingName[] = $side->name; // Assuming 'name' is the column in the `Sides` table
                    }
                    $dippingPrice[] = $dipping['price'];
                    $dippingQuantity[] = $dipping['quantity'];
                }

                // Join the values with '|'
                $dippingName = implode('| ', $dippingName);
                $dippingPrice = implode('| ', $dippingPrice);
                $dippingQuantity = implode('| ', $dippingQuantity);
            } else {
                $dippingName = null;
                $dippingPrice = null;
                $dippingQuantity = null;
            }
            $itemdata = Item::where('slug', $validated['slug'])->first();

            if (!$itemdata) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Item not found.',
                    'buynow' => $request->buynow
                ], 404);
            }

            $branchId = Session::get('branch_id');

            $pizzaBasePrice = PizzaPrice::where('item_id', $itemdata->id)
                ->where('branch_id', $branchId)
                ->where('size_id', $validated['size_id'])
                ->value('price');

            $sizeCrustPrice = ProductSizeCrust::where('item_id', $itemdata->id)
                ->where('size_id', $validated['size_id'])
                ->where('crust_id', $validated['crust_id'])
                ->value('price');

            if ($pizzaBasePrice === null || $sizeCrustPrice === null) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Selected size/crust combination is not available for this item.',
                    'buynow' => $request->buynow
                ], 400);
            }

            $serverItemPrice = $pizzaBasePrice + $sizeCrustPrice;

            if ($request->deal_id) {
                $deal = TopDeals::where('id', $request->deal_id)->first();
                if ($deal && $deal->deal_type == 3) {
                    // Load the current deal_category row
                    $dealCategory = DealCategory::with('dealItem')
                        ->where('id', $request->deal_category_id)
                        ->first();

                    if (!$dealCategory) {
                        return response()->json([
                            'status' => 0,
                            'message' => 'Invalid deal category.',
                            'buynow' => $request->buynow
                        ], 200);
                    }

                    // Base cart query
                    $cartQuery = Auth::check() && Auth::user()->type == 2
                        ? Cart::where('user_id', Auth::id())
                        : Cart::where('session_id', Session::getId());

                    // Load *all* deal categories for this deal
                    $dealCategories = DealCategory::where('deal_id', $request->deal_id)
                        ->with('dealItem')
                        ->get();

                    $totalEligibleSets = null;
                    $totalFreeItemsPerSet = 0;
                    $freeLimits = []; // category_id => max allowed per category

                    // Gather logic across required/free categories
                    foreach ($dealCategories as $category) {
                        $itemIds = $category->dealItem->pluck('item_id');
                        $cartQty = (clone $cartQuery)
                            ->whereIn('item_id', $itemIds)
                            ->where('deal_category_id', $category->id) // ✅ restrict per category record
                            ->sum('qty');

                        if ($category->is_free === 1) {
                            $freeLimits[$category->id] = $category->quantity;
                        } else {
                            $requiredQty = $category->quantity;
                            $sets = intdiv($cartQty, $requiredQty);

                            $totalEligibleSets = is_null($totalEligibleSets)
                                ? $sets
                                : min($totalEligibleSets, $sets);
                        }
                    }

                    $requestedQty = $request->qty ?? 1;

                    // ✅ Work off the specific deal_category being added
                    if ($dealCategory->is_free) {
                        // Must check base requirement first
                        if ($totalEligibleSets < 1) {
                            return response()->json([
                                'status' => 0,
                                'message' => 'Please add the required items to unlock discounted items in this deal.',
                                'buynow' => $request->buynow
                            ], 500);
                        }

                        // Calculate allowed discounted items for this deal
                        $maxDiscountedAllowed = $totalEligibleSets * ($freeLimits[$dealCategory->id] ?? 0);

                        $existingDiscountedQty = (clone $cartQuery)
                            ->where('deal_id', $deal->id)
                            ->where('deal_category_id', $dealCategory->id) // check across all free categories
                            ->sum('qty');


                        if ($existingDiscountedQty + $requestedQty <= $maxDiscountedAllowed) {
                            $serverItemPrice = 0;
                            $request->merge(['is_discounted' => true]);
                        } else {
                            return response()->json([
                                'status' => 0,
                                'message' => 'You have already added the maximum allowed discounted items for this deal. Add more base items to unlock more.',
                                'buynow' => $request->buynow
                            ], 500);
                        }
                    }
                    // else → required category, just use normal price
                }
            }
            $addons_price = $request->addons_price == null ? null :  str_replace('|', '| ', $request->addons_price);
            $normalizedAddonsId = $request->addons_id == null ? null : str_replace('|', '| ', $request->addons_id);
            $requestQty = (int) ($validated['qty'] ?: 1);

            $matchCriteria = [
                'item_id' => $itemdata->id,
                'deal_id' => $request->deal_id ?? null,
                'deal_category_id' => $request->deal_category_id ?? null,
                'size_id' => $validated['size_id'],
                'crust_id' => $validated['crust_id'],
                'addons_id' => $normalizedAddonsId,
                'extras_id' => $request->extras_id ?? null,
                'dipping_name' => $dippingName,
                'buynow' => (int) ($request->buynow ?? 0),
            ];

            $existingLine = $this->findMatchingCartLine($matchCriteria);

            if ($existingLine) {
                log::info('addpizzatocart: matching cart line found, merging qty instead of creating new row', [
                    'cart_id' => $existingLine->id,
                    'old_qty' => $existingLine->qty,
                    'added_qty' => $requestQty,
                    'criteria' => $matchCriteria,
                ]);
                $existingLine->qty += $requestQty;
                $existingLine->save();
                $cart = $existingLine;
            } else {
                log::info('addpizzatocart: no matching cart line found, creating new row', [
                    'criteria' => $matchCriteria,
                ]);
                $cart = new Cart();
                if (Auth::user() && Auth::user()->type == 2) {
                    $cart->user_id = Auth::user()->id;
                    $cart->session_id = "";
                } else {
                    $cart->user_id = "";
                    $cart->session_id = Session::getId();
                }
                $cart->item_id = $itemdata->id;
                $cart->item_name = $request->item_name;
                $cart->deal_id = $request->deal_id ?? null;
                $cart->item_type = $request->item_type;
                $cart->item_image = $request->image_name;
                $cart->tax = $itemdata->tax;
                $cart->deal_category_id = $request->deal_category_id ?? null;
                $cart->item_price = helper::number_format($serverItemPrice);
                $cart->addons_id = $normalizedAddonsId;
                $cart->addons_name = $addons_name;
                $cart->addons_price = $addons_price;
                $cart->addons_total_price = helper::number_format($request->addons_price == "" ? 0 : array_sum(explode('| ', $addons_price)));
                $cart->extras_id = $request->extras_id == null ? null : $request->extras_id;
                $cart->extras_name = $request->extras_name == null ? null : $request->extras_name;
                $cart->extras_price = $request->extras_price == null ? null : $request->extras_price;
                $cart->extras_total_price = helper::number_format($request->extras_price == "" ? 0 : array_sum(explode('| ', $request->extras_price)));
                $cart->dipping_quantity = $dippingQuantity;
                $cart->dipping_name = $dippingName;
                $cart->dipping_price = $dippingPrice;
                $cart->size_id = $validated['size_id'];
                $cart->crust_id = $validated['crust_id'];
                $cart->qty = $requestQty;
                $cart->buynow = $request->buynow;
                $cart->save();
                log::info('addpizzatocart: new cart row created', ['cart_id' => $cart->id]);
            }

            BogoAutoAddService::autoAddFreeItems($cart);


            if (Auth::user() && Auth::user()->type == 2) {
                $total_count = Cart::where('user_id', Auth::user()->id)->where('buynow', 0)->count();
            } else {
                $oldsessionid = Session::getId();
                Session::put('oldsessionid', $oldsessionid);
                $total_count = Cart::where('session_id', Session::getId())->where('buynow', 0)->count();
            }
            session()->forget('discount_data');
            return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $total_count, 'total_item_count' => helper::get_item_cart($itemdata->id), 'buynow' => $request->buynow], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong'), 'buynow' => $request->buynow], 200);
        }
    }
    public function deletecartitem(Request $request)
    {
        $cartQuery = Auth::check() && Auth::user()->type == 2
            ? Cart::where('user_id', Auth::id())
            : Cart::where('session_id', Session::getId());

        $checkcart = (clone $cartQuery)->where('id', $request->id)->first();

        if (!$checkcart) {
            log::info('deletecartitem: cart item not found', ['id' => $request->id]);
            return 0;
        }

        log::info('deletecartitem: request received', [
            'cart_id' => $checkcart->id,
            'item_id' => $checkcart->item_id,
            'item_name' => $checkcart->item_name,
            'deal_id' => $checkcart->deal_id,
            'deal_category_id' => $checkcart->deal_category_id,
            'size_id' => $checkcart->size_id,
            'crust_id' => $checkcart->crust_id,
            'qty' => $checkcart->qty,
        ]);

        // if not part of any deal, delete directly
        if (!$checkcart->deal_id) {
            $checkcart->delete();
            session()->forget('discount_data');
            return 1;
        }

        $result = $this->deleteDealCartLine($checkcart, $cartQuery);

        if (!$result['ok']) {
            return response()->json([
                'status'  => 2,
                'message' => $result['message'],
            ]);
        }

        return 1;
    }


    public function qtyupdate(Request $request)
    {
        $cartQuery = Auth::check() && Auth::user()->type == 2
            ? Cart::where('user_id', Auth::id())
            : Cart::where('session_id', Session::getId());

        $checkcart = (clone $cartQuery)->where('id', $request->id)->first();

        if (!$checkcart) {
            return response()->json(['status' => 0, 'message' => trans('messages.invalid_cart')], 200);
        }

        // Determine total cart quantity
        $total_count = (clone $cartQuery)->sum('qty');

        $needsAutoAdd = false;

        try {
            if ($checkcart->qty == 1 && $request->type == "minus") {
                if ($checkcart->deal_id) {
                    $result = $this->deleteDealCartLine($checkcart, $cartQuery);

                    if (!$result['ok']) {
                        return response()->json(['status' => 2, 'message' => $result['message']], 200);
                    }
                } else {
                    $checkcart->delete();
                    session()->forget('discount_data');
                }
            } else {
                if ($request->type == "plus") {
                    // Handle deal constraints (if deal exists)
                    if ($checkcart->deal_id) {
                        $deal = TopDeals::find($checkcart->deal_id);

                        if ($deal && $deal->deal_type == 3) {
                            // Fetch deal categories
                            $dealCategories = DealCategory::where('deal_id', $deal->id)->get();

                            // Find which category this cart item belongs to
                            $currentItemCategory = $dealCategories->firstWhere('id', $checkcart->deal_category_id);

                            if ($currentItemCategory && $currentItemCategory->is_required) {
                                // Bumping a required item's qty can unlock another free item.
                                // Settle it against THIS item now, instead of leaving the credit
                                // to be claimed by whatever product is added to the cart next.
                                $needsAutoAdd = true;
                            }

                            if ($currentItemCategory && $currentItemCategory->is_free) {
                                // This is a FREE item - check if we can add more
                                $requiredCategories = $dealCategories->where('is_required', true);
                                
                                $totalEligibleSets = null;
                                
                                foreach ($requiredCategories as $requiredCategory) {
                                    $requiredItemIds = DealItem::where('deal_category_id', $requiredCategory->id)->pluck('item_id');
                                    
                                    $cartQty = (clone $cartQuery)
                                        ->where('deal_id', $deal->id)
                                        ->where('deal_category_id', $requiredCategory->id)
                                        ->whereIn('item_id', $requiredItemIds)
                                        ->sum('qty');

                                    $requiredQty = $requiredCategory->quantity;
                                    $sets = intdiv($cartQty, $requiredQty);

                                    $totalEligibleSets = is_null($totalEligibleSets)
                                        ? $sets
                                        : min($totalEligibleSets, $sets);
                                }

                                if ($totalEligibleSets > 0) {
                                    $maxFreeAllowed = $totalEligibleSets * $currentItemCategory->quantity;
                                    
                                    $currentFreeQty = (clone $cartQuery)
                                        ->where('deal_id', $deal->id)
                                        ->where('deal_category_id', $currentItemCategory->id)
                                        ->whereIn('item_id', DealItem::where('deal_category_id', $currentItemCategory->id)->pluck('item_id'))
                                        ->sum('qty');

                                    // Check if adding would exceed free item limit
                                    if ($currentFreeQty + 1 > $maxFreeAllowed) {
                                        return response()->json([
                                            'status' => 2,
                                            'message' => 'You have already added the maximum allowed free items for this deal. Add more required items to unlock more free items.',
                                        ], 200);
                                    }
                                } else {
                                    return response()->json([
                                        'status' => 2,
                                        'message' => 'You need to add the required deal items before increasing free item quantity.',
                                    ], 200);
                                }
                            }
                        }
                    }

                    $checkcart->qty += 1;
                    session()->forget('discount_data');
                }

                if ($request->type == "minus") {
                    $checkcart->qty -= 1;
                    session()->forget('discount_data');

                    if ($checkcart->deal_id) {
                        $deal = TopDeals::find($checkcart->deal_id);

                        if ($deal && $deal->deal_type == 3) {
                            $cartQuery = Auth::check() && Auth::user()->type == 2
                                ? Cart::where('user_id', Auth::id())
                                : Cart::where('session_id', Session::getId());

                            $dealCategories = DealCategory::where('deal_id', $deal->id)->get();

                            // Find which category this cart item belongs to
                            $currentItemCategory = $dealCategories->firstWhere('id', $checkcart->deal_category_id);
                            
                            if ($currentItemCategory && $currentItemCategory->is_required) {
                                // This is a REQUIRED item - check if decreasing would orphan free items
                                
                                // Calculate current sets BEFORE decrease
                                $requiredItemIds = DealItem::where('deal_category_id', $currentItemCategory->id)->pluck('item_id');
                                $currentRequiredQty = (clone $cartQuery)
                                    ->where('deal_id', $deal->id)
                                    ->where('deal_category_id', $currentItemCategory->id)
                                    ->whereIn('item_id', $requiredItemIds)
                                    ->sum('qty');

                                $currentSets = intdiv($currentRequiredQty, $currentItemCategory->quantity);

                                // Calculate sets AFTER decrease
                                $requiredQtyAfterDecrease = $currentRequiredQty - 1;
                                $setsAfterDecrease = intdiv($requiredQtyAfterDecrease, $currentItemCategory->quantity);

                                // If sets are reduced, check for orphaned free items
                                if ($setsAfterDecrease < $currentSets) {
                                    $freeCategories = $dealCategories->where('is_free', true);
                                    
                                    foreach ($freeCategories as $freeCategory) {
                                        $freeItemIds = DealItem::where('deal_category_id', $freeCategory->id)->pluck('item_id');
                                        
                                        $currentFreeQty = (clone $cartQuery)
                                            ->where('deal_id', $deal->id)
                                            ->where('deal_category_id', $freeCategory->id)
                                            ->whereIn('item_id', $freeItemIds)
                                            ->sum('qty');

                                        $allowedFreeAfterDecrease = $setsAfterDecrease * $freeCategory->quantity;

                                        if ($currentFreeQty > $allowedFreeAfterDecrease) {
                                            $excessFreeItems = $currentFreeQty - $allowedFreeAfterDecrease;

                                            // Prefer auto-removing the matching free item for the
                                            // SAME product before falling back to blocking.
                                            $excessFreeItems -= $this->cascadeRemoveDealItem($deal, [$freeCategory->id], $checkcart->item_id, $excessFreeItems);

                                            if ($excessFreeItems > 0) {
                                                return response()->json([
                                                    'status' => 2,
                                                    'message' => "You cannot decrease this required item. You have {$excessFreeItems} free item(s) that depend on it. Please remove free items first.",
                                                ], 200);
                                            }
                                        }
                                    }
                                }
                            } elseif ($currentItemCategory && $currentItemCategory->is_free) {
                                // Decreasing a free item's qty should also decrease its paid
                                // counterpart (same item_id, same deal) by the same amount, so
                                // the paid/free pairing for this specific product stays in sync.
                                $requiredCategoryIds = $dealCategories->where('is_required', true)->pluck('id');
                                $this->cascadeRemoveDealItem($deal, $requiredCategoryIds, $checkcart->item_id, 1);
                            }
                        }
                    }
                }

                $checkcart->save();

                if ($needsAutoAdd) {
                    BogoAutoAddService::autoAddFreeItems($checkcart);
                }
            }

            return response()->json(['status' => 1, 'message' => trans('messages.success')]);
        } catch (\Throwable $th) {

            return response()->json(['status' => 0, 'message' => trans('messages.wrong')]);
        }
    }
}
