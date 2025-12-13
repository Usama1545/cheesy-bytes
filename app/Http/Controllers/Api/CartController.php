<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DealCategory;
use App\Models\Sides;
use App\Models\TopDeals;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Item;
use App\Helpers\helper;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\DealItem;
use App\Models\Addons;
use App\Models\Extra;
use Session;
use Illuminate\Support\Facades\log;

class CartController extends Controller
{
   public function addtocart(Request $request)
    {
        try {
            // Base validation for all items
            $validated = $request->validate([
                'slug' => 'required|string|exists:item,slug',
                'qty' => 'required|integer|min:1',
                'branch_id' => 'required|integer|exists:branches,id',
                'item_price' => 'required|numeric|min:0',
            ]);

            $sessionId = $request->header('X-Session-Id');
            $user = auth('sanctum')->user();
            $userId = $user ? $user->id : null;
            
            if (!$userId && !$sessionId) {
                return response()->json([
                    'status' => false,
                    'message' => 'Please login or provide Session ID. Please provide X-Session-Id header.',
                    'buynow' => $request->buynow ?? 0
                ], 400);
            }

            $branchId = $validated['branch_id'];
            
            // Handle buynow clearance
            if ($request->buynow == 1) {
                if ($userId) {
                    Cart::where('buynow', 1)->where('user_id', $userId)->delete();
                } else {
                    Cart::where('buynow', 1)->where('session_id', $sessionId)->delete();
                }
            }
            
            // Get item data
            $itemdata = Item::where('slug', $validated['slug'])
                ->with(['sizes', 'crusts','category_info'])
                ->first();

            if (!$itemdata) {
                return response()->json([
                    'status' => false,
                    'message' => 'Item not found.',
                    'buynow' => $request->buynow ?? 0
                ], 404);
            }

            // Check if item is pizza (type 2) and validate pizza-specific fields
            $isPizza = $itemdata->category_info->slug == 'pizza';
            
            if ($isPizza) {
                $pizzaValidation = Validator::make($request->all(), [
                    'size_id' => 'required|integer|exists:sizes,id',
                    'crust_id' => 'required|integer|exists:crusts,id',
                ]);

                if ($pizzaValidation->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Pizza validation failed',
                        'errors' => $pizzaValidation->errors(),
                        'buynow' => $request->buynow ?? 0
                    ], 422);
                }

                // Validate size and crust belong to this item
                $validSize = $itemdata->sizes->contains('id', $request->size_id);
                $validCrust = $itemdata->crusts->contains('id', $request->crust_id);
                
                if (!$validSize || !$validCrust) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Invalid size or crust for this pizza.',
                        'buynow' => $request->buynow ?? 0
                    ], 400);
                }
            }

            // Validate deal if provided
            if ($request->has('deal_id') && $request->deal_id) {
                $dealValidation = Validator::make($request->all(), [
                    'deal_id' => 'integer|exists:top_deals,id',
                ]);

                if ($dealValidation->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Deal validation failed',
                        'errors' => $dealValidation->errors(),
                        'buynow' => $request->buynow ?? 0
                    ], 422);
                }

                $deal = TopDeals::find($request->deal_id);
                
                if ($deal && $deal->deal_type == 3) {
                    $dealValidation = Validator::make($request->all(), [
                        'deal_category_id' => 'required|integer|exists:deal_categories,id',
                    ]);
                    
                    if ($dealValidation->fails()) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Deal category is required for this deal.',
                            'errors' => $dealValidation->errors(),
                            'buynow' => $request->buynow ?? 0
                        ], 422);
                    }
                    $dealCategory = DealCategory::with('dealItem')
                        ->where('id', $request->deal_category_id)
                        ->first();

                    if (!$dealCategory) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Invalid deal category.',
                            'buynow' => $request->buynow ?? 0
                        ], 400);
                    }

                    $cartQuery = $userId 
                        ? Cart::where('user_id', $userId)
                        : Cart::where('session_id', $sessionId);

                    $dealCategories = DealCategory::where('deal_id', $request->deal_id)
                        ->with('dealItem')
                        ->get();

                    $totalEligibleSets = null;
                    $freeLimits = [];

                    foreach ($dealCategories as $category) {
                        $itemIds = $category->dealItem->pluck('item_id');
                        $cartQty = (clone $cartQuery)
                            ->whereIn('item_id', $itemIds)
                            ->where('deal_category_id', $category->id)
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

                    $requestedQty = $validated['qty'];

                    if ($dealCategory->is_free) {
                        if ($totalEligibleSets < 1) {
                            return response()->json([
                                'status' => false,
                                'message' => 'Please add the required items to unlock discounted items in this deal.',
                                'buynow' => $request->buynow ?? 0
                            ], 400);
                        }

                        $maxDiscountedAllowed = $totalEligibleSets * ($freeLimits[$dealCategory->id] ?? 0);

                        $existingDiscountedQty = (clone $cartQuery)
                            ->where('deal_id', $deal->id)
                            ->where('deal_category_id', $dealCategory->id)
                            ->sum('qty');

                        if ($existingDiscountedQty + $requestedQty > $maxDiscountedAllowed) {
                            return response()->json([
                                'status' => false,
                                'message' => 'You have already added the maximum allowed discounted items for this deal. Add more base items to unlock more.',
                                'buynow' => $request->buynow ?? 0
                            ], 400);
                        }
                    }
                }
            }

            // Process addons (for all item types)
            $addonIds = $request->addons_id ?? [];
            $addonIds = is_array($addonIds) ? $addonIds : (is_string($addonIds) ? explode(',', $addonIds) : []);
            $addonIds = array_filter($addonIds, fn($id) => !empty($id));

            $addonsIds = '';
            $addonsNames = '';
            $addonsPrices = '';
            $addonsTotalPrice = 0;

            if (!empty($addonIds)) {
                $validAddons = Addons::whereIn('id', $addonIds)->count();
                if ($validAddons != count(array_unique($addonIds))) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Invalid addons provided.',
                        'buynow' => $request->buynow ?? 0
                    ], 400);
                }

                $addons = Addons::whereIn('id', $addonIds)->get();
                $addonsIds = $addons->pluck('id')->implode('|');
                $addonsNames = $addons->pluck('name')->implode('|');
                $addonsPrices = $addons->pluck('price')->implode('|');
                $addonsTotalPrice = $addons->sum('price');
            }

            // Process extras (for all item types)
            $extraIds = $request->extras_id ?? [];
            $extraIds = is_array($extraIds) ? $extraIds : (is_string($extraIds) ? explode(',', $extraIds) : []);
            $extraIds = array_filter($extraIds, fn($id) => !empty($id));

            $extrasIds = '';
            $extrasNames = '';
            $extrasPrices = '';
            $extrasTotalPrice = 0;

            if (!empty($extraIds)) {
                $validExtras = Extra::whereIn('id', $extraIds)->count();
                if ($validExtras != count(array_unique($extraIds))) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Invalid extras provided.',
                        'buynow' => $request->buynow ?? 0
                    ], 400);
                }

                $extras = Extra::whereIn('id', $extraIds)->get();
                $extrasIds = $extras->pluck('id')->implode('|');
                $extrasNames = $extras->pluck('name')->implode('|');
                $extrasPrices = $extras->pluck('price')->implode('|');
                $extrasTotalPrice = $extras->sum('price');
            }

            // Process dippings (for pizzas only)
            $dippingQuantity = null;
            $dippingName = null;
            $dippingPrice = null;

            if ($isPizza && $request->has('dippings')) {
                $dippings = $request->dippings;
                
                if (!is_array($dippings)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Dippings must be an array.',
                        'buynow' => $request->buynow ?? 0
                    ], 400);
                }

                $dippingNames = [];
                $dippingPrices = [];
                $dippingQuantities = [];

                foreach ($dippings as $dipping) {
                    if (!isset($dipping['id']) || !isset($dipping['price']) || !isset($dipping['quantity'])) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Each dipping must have id, price, and quantity.',
                            'buynow' => $request->buynow ?? 0
                        ], 400);
                    }

                    $side = Sides::find($dipping['id']);
                    if (!$side) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Invalid dipping ID: ' . $dipping['id'],
                            'buynow' => $request->buynow ?? 0
                        ], 400);
                    }

                    $dippingNames[] = $side->name;
                    $dippingPrices[] = $dipping['price'];
                    $dippingQuantities[] = $dipping['quantity'];
                }

                $dippingName = implode('|', $dippingNames);
                $dippingPrice = implode('|', $dippingPrices);
                $dippingQuantity = implode('|', $dippingQuantities);
            }

            // Create cart item
            $cart = new Cart();
            $cart->user_id = $userId ?: null;
            $cart->session_id = $userId ? null : $sessionId;
            $cart->item_id = $itemdata->id;
            $cart->deal_id = $request->deal_id ?? null;
            $cart->item_name = $request->item_name ?? $itemdata->item_name;
            $cart->item_type = $itemdata->type;
            $cart->item_image = $itemdata->image ?? null;
            $cart->deal_category_id = $request->deal_category_id ?? null;
            $cart->tax = $itemdata->tax ?? 0;
            $cart->item_price = helper::number_format($validated['item_price'] / $validated['qty']);

            // Addons
            $cart->addons_id = $addonsIds;
            $cart->addons_name = $addonsNames;
            $cart->addons_price = $addonsPrices;
            $cart->addons_total_price = helper::number_format($addonsTotalPrice);

            // Extras
            $cart->extras_id = $extrasIds;
            $cart->extras_name = $extrasNames;
            $cart->extras_price = $extrasPrices;
            $cart->extras_total_price = helper::number_format($extrasTotalPrice);

            // Pizza-specific fields
            if ($isPizza) {
                $cart->size_id = $request->size_id;
                $cart->crust_id = $request->crust_id;
                $cart->dipping_quantity = $dippingQuantity;
                $cart->dipping_name = $dippingName;
                $cart->dipping_price = $dippingPrice;
            }

            $cart->qty = $validated['qty'];
            $cart->buynow = $request->buynow ?? 0;
            $cart->branch_id = $branchId;
            $cart->special_instructions = $request->special_instructions ?? null;
            $cart->save();

            // Get cart count
            $cartQuery = $userId 
                ? Cart::where('user_id', $userId)
                : Cart::where('session_id', $sessionId);

            $totalCount = $cartQuery
                ->where('buynow', 0)
                ->where('branch_id', $branchId)
                ->count();

            return response()->json([
                'status' => true,
                'message' => 'Item added to cart successfully.',
                'data' => [
                    'cart_count' => $totalCount,
                    'item_count' => $cart->qty,
                    'cart_item_id' => $cart->id,
                    'session_id' => $sessionId,
                    'item_type' => $isPizza ? 'pizza' : 'regular',
                    'item_name' => $itemdata->item_name,
                    'unit_price' => (float)$validated['item_price'] / $validated['qty'],
                    'total_price' => (float)$validated['item_price'] + $addonsTotalPrice + $extrasTotalPrice,
                    'branch_id' => $branchId
                ],
                'buynow' => $request->buynow ?? 0
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'buynow' => $request->buynow ?? 0
            ], 422);
        } catch (\Throwable $th) {
            Log::error('Add to cart error: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString(),
                'request' => $request->all(),
                'session_id' => $request->header('X-Session-Id')
            ]);
            
            return response()->json([
                'status' => false,
                'message' => 'Failed to add item to cart.',
                'error' => config('app.debug') ? $th->getMessage() : null,
                'buynow' => $request->buynow ?? 0
            ], 500);
        }
    }
    public function removeCartItem(Request $request)
    {
        $sessionId = $request->header('X-Session-Id');

        try {
            $validator = $request->validate([
                'id' => 'required|integer|exists:cart,id'
            ]);

            $checkcart = Cart::find($request->id);

            if (!$checkcart) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cart item not found'
                ], 404);
            }

            $cartQuery = Auth::check() && auth('sanctum')->user()->type == 2
                ? Cart::where('user_id', Auth::id())
                : Cart::where('session_id', $sessionId);

            if (!$checkcart->deal_id) {
                $checkcart->delete();
                session()->forget('discount_data');
                
                $cart_count = $cartQuery->count();
                $cart_total = $cartQuery->sum('qty');
                
                return response()->json([
                    'status' => true,
                    'message' => 'Item removed from cart successfully',
                    'data' => [
                        'cart_count' => $cart_count,
                        'cart_total' => $cart_total
                    ]
                ]);
            }

            $deal = TopDeals::find($checkcart->deal_id);
            if (!$deal || $deal->deal_type != 3) {
                // normal delete if not a "Buy X get Y free" type deal
                $checkcart->delete();
                session()->forget('discount_data');
                
                $cart_count = $cartQuery->count();
                $cart_total = $cartQuery->sum('qty');
                
                return response()->json([
                    'status' => true,
                    'message' => 'Item removed from cart successfully',
                    'data' => [
                        'cart_count' => $cart_count,
                        'cart_total' => $cart_total
                    ]
                ]);
            }

            // ✅ Free item → allow delete always
            $dealCategory = DealCategory::find($checkcart->deal_category_id);
            if ($dealCategory && $dealCategory->is_free) {
                $checkcart->delete();
                session()->forget('discount_data');
                
                $cart_count = $cartQuery->count();
                $cart_total = $cartQuery->sum('qty');
                
                return response()->json([
                    'status' => true,
                    'message' => 'Free item removed from cart successfully',
                    'data' => [
                        'cart_count' => $cart_count,
                        'cart_total' => $cart_total
                    ]
                ]);
            }

            // ✅ Required item — need to check validation
            // Get all deal categories for this deal
            $dealCategories = DealCategory::where('deal_id', $deal->id)->get();

            // Find the required category that this item belongs to
            $requiredCategory = $dealCategories->firstWhere('id', $checkcart->deal_category_id);
            
            if (!$requiredCategory || !$requiredCategory->is_required) {
                $checkcart->delete();
                session()->forget('discount_data');
                
                $cart_count = $cartQuery->count();
                $cart_total = $cartQuery->sum('qty');
                
                return response()->json([
                    'status' => true,
                    'message' => 'Item removed from cart successfully',
                    'data' => [
                        'cart_count' => $cart_count,
                        'cart_total' => $cart_total
                    ]
                ]);
            }

            // STEP 1: Calculate current sets BEFORE deletion
            $requiredItemIds = DealItem::where('deal_category_id', $requiredCategory->id)->pluck('item_id');
            $currentRequiredQty = (clone $cartQuery)
                ->whereIn('item_id', $requiredItemIds)
                ->where('deal_id', $deal->id)
                ->where('deal_category_id', $requiredCategory->id)
                ->sum('qty');

            $currentSets = intdiv($currentRequiredQty, $requiredCategory->quantity);

            // STEP 2: Calculate sets AFTER deletion
            $requiredQtyAfterDeletion = $currentRequiredQty - $checkcart->qty;
            $setsAfterDeletion = intdiv($requiredQtyAfterDeletion, $requiredCategory->quantity);
            
            // If sets don't change, safe to delete
            if ($setsAfterDeletion >= $currentSets) {
                $checkcart->delete();
                session()->forget('discount_data');
                
                $cart_count = $cartQuery->count();
                $cart_total = $cartQuery->sum('qty');
                
                return response()->json([
                    'status' => true,
                    'message' => 'Item removed from cart successfully',
                    'data' => [
                        'cart_count' => $cart_count,
                        'cart_total' => $cart_total
                    ]
                ]);
            }

            // STEP 3: Sets are reduced - check if we have excess free items
            $freeCategories = $dealCategories->where('is_free', true);
            
            foreach ($freeCategories as $freeCategory) {
                $freeItemIds = DealItem::where('deal_category_id', $freeCategory->id)->pluck('item_id');
                
                $currentFreeQty = (clone $cartQuery)
                    ->whereIn('item_id', $freeItemIds)
                    ->where('deal_id', $deal->id)
                    ->where('deal_category_id', $freeCategory->id)
                    ->sum('qty');

                // Calculate how many free items are allowed based on current sets vs after deletion
                $currentlyAllowedFree = $currentSets * $freeCategory->quantity;
                $allowedFreeAfterDeletion = $setsAfterDeletion * $freeCategory->quantity;

                // If we have more free items than will be allowed after deletion, block the delete
                if ($currentFreeQty > $allowedFreeAfterDeletion) {
                    $excessFreeItems = $currentFreeQty - $allowedFreeAfterDeletion;
                    return response()->json([
                        'status' => false,
                        'message' => "You cannot delete this required item. You have {$excessFreeItems} free item(s) that depend on it. Please remove the free items first.",
                    ], 400);
                }
            }

            // ✅ Passed validation — allow deletion
            $checkcart->delete();
            session()->forget('discount_data');
            
            $cart_count = $cartQuery->count();
            $cart_total = $cartQuery->sum('qty');
            
            return response()->json([
                'status' => true,
                'message' => 'Item removed from cart successfully',
                'data' => [
                    'cart_count' => $cart_count,
                    'cart_total' => $cart_total
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while removing item from cart',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function qtyupdate(Request $request)
    {
        $sessionId = $request->header('X-Session-Id');
        try {
            $validator = $request->validate([
                'id' => 'required|integer|exists:cart,id',
                'type' => 'required|in:plus,minus'
            ]);

            $checkcart = Cart::find($request->id);

            if (!$checkcart) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cart item not found'
                ], 404);
            }

            // Determine cart query for totals
            $cartQuery = Auth::check() && auth('sanctum')->user()->type == 2
                ? Cart::where('user_id', Auth::id())
                : Cart::where('session_id', $sessionId);

            if ($checkcart->qty == 1 && $request->type == "minus") {
                // Delete the item if quantity would become 0
                $checkcart->delete();
                session()->forget('discount_data');
                
                $cart_count = $cartQuery->count();
                $cart_total = $cartQuery->sum('qty');
                
                return response()->json([
                    'status' => true,
                    'message' => 'Item removed from cart',
                    'data' => [
                        'cart_count' => $cart_count,
                        'cart_total' => $cart_total,
                        'item_removed' => true
                    ]
                ]);
            }

            $oldQty = $checkcart->qty;
            
            if ($request->type == "plus") {
                // Handle deal constraints (if deal exists)
                if ($checkcart->deal_id) {
                    $deal = TopDeals::find($checkcart->deal_id);

                    if ($deal && $deal->deal_type == 3) {
                        // Fetch deal categories
                        $dealCategories = DealCategory::where('deal_id', $deal->id)->get();

                        // Find which category this cart item belongs to
                        $currentItemCategory = $dealCategories->firstWhere('id', $checkcart->deal_category_id);
                        
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
                                        'status' => false,
                                        'message' => 'You have already added the maximum allowed free items for this deal. Add more required items to unlock more free items.',
                                    ], 400);
                                }
                            } else {
                                return response()->json([
                                    'status' => false,
                                    'message' => 'You need to add the required deal items before increasing free item quantity.',
                                ], 400);
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
                                            'status' => false,
                                            'message' => "You cannot decrease this required item. You have {$excessFreeItems} free item(s) that depend on it. Please remove free items first.",
                                        ], 400);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $checkcart->save();
            
            $cart_count = $cartQuery->count();
            $cart_total = $cartQuery->sum('qty');
            
            return response()->json([
                'status' => true,
                'message' => 'Cart quantity updated successfully',
                'data' => [
                    'cart_count' => $cart_count,
                    'cart_total' => $cart_total,
                    'item_qty' => $checkcart->qty,
                    'item_price' => $checkcart->price,
                    'item_total' => $checkcart->qty * $checkcart->price,
                    'item_removed' => false
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while updating cart quantity',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function index(Request $request)
    {
        $sessionId = $request->header('X-Session-Id');
        try {
            if (auth('sanctum')->user() && auth('sanctum')->user()->type == 2) {
                $getcartlist = Cart::where('user_id', auth('sanctum')->user()->id)->orderByDesc('id')->get();
            } else {
                $getcartlist = Cart::where('session_id', $sessionId)->orderByDesc('id')->get();
            }

            $getsettings = Settings::first();
            $tax_name = [];
            $tax_price = [];

            foreach ($getcartlist as $cart) {
                $taxlist = helper::gettax($cart->tax);
                if (!empty($taxlist)) {
                    foreach ($taxlist as $tax) {
                        if (!empty($tax)) {
                            if (!in_array($tax->name, $tax_name)) {
                                $tax_name[] = $tax->name;

                                if ($tax->type == 1) {
                                    $price = $tax->tax * $cart->qty;
                                }

                                if ($tax->type == 2) {
                                    $price = ($tax->tax / 100) * ($cart->addons_total_price + $cart->extras_total_price + $cart->item_price) * $cart->qty;
                                }
                                $tax_price[] = $price;
                            } else {
                                if ($tax->type == 1) {
                                    $price = $tax->tax * $cart->qty;
                                }

                                if ($tax->type == 2) {
                                    $price = ($tax->tax / 100) * ($cart->addons_total_price + $cart->extras_total_price + $cart->item_price) * $cart->qty;
                                }
                                $tax_price[array_search($tax->name, $tax_name)] += $price;
                            }
                        }
                    }
                }
            }

            $discount = helper::calculateDiscount($getcartlist);
            
            // Calculate totals
            $subtotal = 0;
            foreach ($getcartlist as $item) {
                $itemTotal = (($item->item_price + $item->addons_total_price + $cart->extras_total_price )* $item->qty);
                $subtotal += $itemTotal;
            }
            
            $total_tax = array_sum($tax_price);
            $discount_amount = $discount['total_discount'] ?? 0;
            $grand_total = $subtotal + $total_tax - $discount_amount;

            return response()->json([
                'status' => true,
                'message' => 'Cart retrieved successfully',
                'data' => [
                    'cart_items' => $getcartlist->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'item_id' => $item->item_id,
                            'deal_id' => $item->deal_id,
                            'deal_category_id' => $item->deal_category_id,
                            'item_name' => $item->item_name,
                            'item_price' => $item->item_price,
                            'item_image' => json_decode($item->item_image)->image_url ?? '',
                            'addons_id' => explode("|", $item->addons_id),
                            "addons_name" => explode("|", $item->addons_name),
                            'addons_total_price' => $item->addons_total_price,
                            'extras' => explode("|", $item->extras_id),
                            'extras_name' => explode("|", $item->extras_name),
                            'extras_total_price' => $item->extras_total_price,
                            'qty' => $item->qty,
                            'tax' => $item->tax,
                            'total_price' => round(($item->item_price + $item->addons_total_price + $item->extras_total_price )* $item->qty,2), // round($item->item_price + $item->addons_total_price + $item->extras_total_price + $item->tax * $item->qty,
                        ];
                    }),
                    // 'settings' => $getsettings,
                    'taxes' => [
                        'names' => $tax_name,
                        'prices' => $tax_price
                    ],
                    'discount' => $discount,
                    'totals' => [
                        'subtotal' => round($subtotal,2),
                        'tax_total' => round($total_tax,2),
                        'discount_amount' => round($discount_amount,2),
                        'grand_total' => round($grand_total,2)
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve cart',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

}
