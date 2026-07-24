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
use App\Helpers\helper;
use App\Services\BogoAutoAddService;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DealItem;
use Session;
use Illuminate\Support\Facades\log;

class CartController extends Controller
{
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
        
        log::info('yes i am hit');
        $branchId = Session::get('branch_id');

        try {
            if ($request->buynow == 1) {
                if (Auth::user() && Auth::user()->type == 2) {
                    Cart::where('buynow', 1)->where('user_id', Auth::user()->id)->delete();
                } else {
                    Cart::where('buynow', 1)->where('session_id', Session::getId())->delete();
                }
            }
            $itemdata = Item::where('slug', $request->slug)->select('item.*',
                DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"))
                ->leftJoin('item_prices', function ($query) use ($branchId) {
                    $query->on('item_prices.item_id', '=', 'item.id')
                        ->where('item_prices.branch_id', '=', $branchId);
                })->first();

            $serverItemPrice = $itemdata->item_price;

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
            $cart->qty = $request->qty;
            $cart->buynow = $request->buynow;
            $cart->save();

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

            $sizeCrustPrice = ProductSizeCrust::where('item_id', $itemdata->id)
                ->where('size_id', $validated['size_id'])
                ->where('crust_id', $validated['crust_id'])
                ->value('price');

            if ($sizeCrustPrice === null) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Selected size/crust combination is not available for this item.',
                    'buynow' => $request->buynow
                ], 400);
            }

            $serverItemPrice = $sizeCrustPrice;

            $cart = new Cart();
            if (Auth::user() && Auth::user()->type == 2) {
                $cart->user_id = Auth::user()->id;
                $cart->session_id = "";
            } else {
                $cart->user_id = "";
                $cart->session_id = Session::getId();
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
            $cart->item_id = $itemdata->id;
            $cart->item_name = $request->item_name;
            $cart->deal_id = $request->deal_id ?? null;
            $cart->item_type = $request->item_type;
            $cart->item_image = $request->image_name;
            $cart->tax = $itemdata->tax;
            $cart->deal_category_id = $request->deal_category_id ?? null;
            $cart->item_price = helper::number_format($serverItemPrice);
            $cart->addons_id = $request->addons_id == null ? null : str_replace('|', '| ', $request->addons_id) ;
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
            $cart->qty = $validated['qty'];
            $cart->buynow = $request->buynow;
            $cart->save();

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
            return 0;
        }

        // if not part of any deal, delete directly
        if (!$checkcart->deal_id) {
            $checkcart->delete();
            session()->forget('discount_data');
            return 1;
        }

        $deal = TopDeals::find($checkcart->deal_id);
        if (!$deal || $deal->deal_type != 3) {
            // normal delete if not a "Buy X get Y free" type deal
            $checkcart->delete();
            session()->forget('discount_data');
            return 1;
        }

        // ✅ Free item → allow delete always
        $dealCategory = DealCategory::find($checkcart->deal_category_id);
        if ($dealCategory && $dealCategory->is_free) {
            $checkcart->delete();
            session()->forget('discount_data');
            return 1;
        }

        // ✅ Required item — need to check validation
        // Get all deal categories for this deal
        $dealCategories = DealCategory::where('deal_id', $deal->id)->get();

        // Find the required category that this item belongs to
        $requiredCategory = $dealCategories->firstWhere('id', $checkcart->deal_category_id);
        
        if (!$requiredCategory || !$requiredCategory->is_required) {
            $checkcart->delete();
            session()->forget('discount_data');
            return 1;
        }

        // STEP 1: Calculate current sets BEFORE deletion
        $requiredItemIds = DealItem::where('deal_category_id', $requiredCategory->id)->pluck('item_id');
        $currentRequiredQty = (clone $cartQuery)
            ->whereIn('item_id', $requiredItemIds)->where('deal_id', $deal->id)->where('deal_category_id', $requiredCategory->id)
            ->sum('qty');

        $currentSets = intdiv($currentRequiredQty, $requiredCategory->quantity);

        // STEP 2: Calculate sets AFTER deletion
        $requiredQtyAfterDeletion = $currentRequiredQty - $checkcart->qty;
        $setsAfterDeletion = intdiv($requiredQtyAfterDeletion, $requiredCategory->quantity);
        // If sets don't change, safe to delete
        if ($setsAfterDeletion >= $currentSets) {
            $checkcart->delete();
            session()->forget('discount_data');
            return 1;
        }

        // STEP 3: Sets are reduced - check if we have excess free items
        $freeCategories = $dealCategories->where('is_free', true);
        
        foreach ($freeCategories as $freeCategory) {
            $freeItemIds = DealItem::where('deal_category_id', $freeCategory->id)->pluck('item_id');
            
            $currentFreeQty = (clone $cartQuery)
                ->whereIn('item_id', $freeItemIds)->where('deal_id', $deal->id)->where('deal_category_id', $freeCategory->id)
                ->sum('qty');


            // Calculate how many free items are allowed based on current sets vs after deletion
            $currentlyAllowedFree = $currentSets * $freeCategory->quantity;
            $allowedFreeAfterDeletion = $setsAfterDeletion * $freeCategory->quantity;

            // If we have more free items than will be allowed after deletion, block the delete
            if ($currentFreeQty > $allowedFreeAfterDeletion) {
                $excessFreeItems = $currentFreeQty - $allowedFreeAfterDeletion;
                return response()->json([
                    'status'  => 2,
                    'message' => "You cannot delete this required item. You have {$excessFreeItems} free item(s) that depend on it. Please remove the free items first.",
                ]);
            }
        }

        // ✅ Passed validation — allow deletion
        $checkcart->delete();
        session()->forget('discount_data');
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
            $checkcart->delete();
            session()->forget('discount_data');
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
                                        return response()->json([
                                            'status' => 2,
                                            'message' => "You cannot decrease this required item. You have {$excessFreeItems} free item(s) that depend on it. Please remove free items first.",
                                        ], 200);
                                    }
                                }
                            }
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
