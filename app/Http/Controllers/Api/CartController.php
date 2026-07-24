<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DealCategory;
use App\Models\Sides;
use App\Models\TopDeals;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Item;
use App\Models\ProductSizeCrust;
use App\Helpers\helper;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DealItem;
use App\Models\Addons;
use App\Models\Extra;
use App\Services\BogoAutoAddService;
use Session;
use Illuminate\Support\Facades\log;

class CartController extends Controller
{
    public function addtocart(Request $request)
    {
        log::info('add to cart',[
            'request' => $request->all(),
        ]);
        // Validate required fields
        $validated = $request->validate([
            'slug' => 'required|string',
            'qty' => 'required|integer|min:1',
            'branch_id' => 'required|integer|exists:branches,id',
            'item_price' => 'required|numeric|min:0',
        ]);

        $sessionId = $request->header('X-Session-Id');
        $userId = auth('sanctum')->user()->id ??  null;
        
        if (!$userId && !$sessionId) {
            return response()->json([
                'status' => 0,
                'message' => 'Please login or provide Session ID. Please provide X-Session-Id header.',
                'buynow' => $request->buynow ?? 0
            ], 400);
        }

        $branchId = $validated['branch_id'];
        
        try {
            // Handle buynow clearance
            if ($request->buynow == 1) {
                if (auth('sanctum')->user() && auth('sanctum')->user()->type == 2) {
                    Cart::where('buynow', 1)->where('user_id', auth('sanctum')->user()->id)->delete();
                } else {
                    Cart::where('buynow', 1)->where('session_id', $sessionId)->delete();
                }
            }
            
            // Get item data with branch-specific pricing
            $itemdata = Item::where('slug', $validated['slug'])
                ->select('item.*',
                    DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price")
                )
                ->leftJoin('item_prices', function ($query) use ($branchId) {
                    $query->on('item_prices.item_id', '=', 'item.id')
                        ->where('item_prices.branch_id', '=', $branchId);
                })
                ->first();

            if (!$itemdata) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Item not found.',
                    'buynow' => $request->buynow ?? 0
                ], 404);
            }

            $serverItemPrice = $itemdata->item_price;

            // Validate deal if provided
            if ($request->has('deal_id') && $request->deal_id) {
                $request->validate([
                    'deal_id' => 'integer|exists:top_deals,id',
                ]);

                $deal = TopDeals::where('id', $request->deal_id)->first();

                if ($deal && $deal->deal_type == 3) {
                    $request->validate([
                        'deal_category_id' => 'required|integer|exists:deal_categories,id',
                    ]);
                    $dealCategory = DealCategory::with('dealItem')
                        ->where('id', $request->deal_category_id)
                        ->first();

                    if (!$dealCategory) {
                        return response()->json([
                            'status' => 0,
                            'message' => 'Invalid deal category.',
                            'buynow' => $request->buynow ?? 0
                        ], 400);
                    }

                    // Base cart query
                    $cartQuery = auth('sanctum')->user() && auth('sanctum')->user()->type == 2
                        ? Cart::where('user_id', auth('sanctum')->user()->id)
                        : Cart::where('session_id', $sessionId);

                    // Load all deal categories for this deal
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
                                'status' => 0,
                                'message' => 'Please add the required items to unlock discounted items in this deal.',
                                'buynow' => $request->buynow ?? 0
                            ], 400);
                        }

                        $maxDiscountedAllowed = $totalEligibleSets * ($freeLimits[$dealCategory->id] ?? 0);

                        $existingDiscountedQty = (clone $cartQuery)
                            ->where('deal_id', $deal->id)
                            ->where('deal_category_id', $dealCategory->id)
                            ->sum('qty');

                        if ($existingDiscountedQty + $requestedQty <= $maxDiscountedAllowed) {
                            $serverItemPrice = 0;
                            $request->merge(['is_discounted' => true]);
                        } else {
                            return response()->json([
                                'status' => 0,
                                'message' => 'You have already added the maximum allowed discounted items for this deal. Add more base items to unlock more.',
                                'buynow' => $request->buynow ?? 0
                            ], 400);
                        }
                    }
                }
            }
            // Default empty values
            $addonIds     = [];
            $extraIds     = [];

            $addonsIds    = '';
            $addonsNames  = '';
            $addonsPrices = '';

            $extrasIds    = '';
            $extrasNames  = '';
            $extrasPrices = '';

            // Validate addons/extras if provided
            if ($request->has('addons_id')) {
                $addonIds = $request->addons_id ?? [];
                $addonIds = is_array($addonIds) ? $addonIds : [$addonIds];
                $addonIds = array_filter($addonIds, fn($id) => !empty($id));
                if (!empty($addonIds)) {
                    $validAddons = Addons::whereIn('id', $addonIds)->count();
                    if ($validAddons != count(array_unique($addonIds))) {
                        return response()->json([
                            'status' => 0,
                            'message' => 'Invalid addons provided.',
                            'buynow' => $request->buynow ?? 0
                        ], 400);
                    }
                }
            }

            if ($request->has('extras_id')) {
                $extraIds = $request->extras_id ?? [];
                $extraIds = is_array($extraIds) ? $extraIds : [$extraIds];
                $extraIds = array_filter($extraIds, fn($id) => !empty($id));
                if (!empty($extraIds)) {
                    $validExtras = Extra::whereIn('id', $extraIds)->count();
                    if ($validExtras != count(array_unique($extraIds))) {
                        return response()->json([
                            'status' => 0,
                            'message' => 'Invalid extras provided.',
                            'buynow' => $request->buynow ?? 0
                        ], 400);
                    }
                }
            }
            if (!empty($addonIds)) {
                $addons        = Addons::whereIn('id', $addonIds)->get();
                $addonsIds     = $addons->pluck('id')->implode('|');
                $addonsNames   = $addons->pluck('name')->implode('|');
                $addonsPrices  = $addons->pluck('price')->implode('|');
            }

            if (!empty($extraIds)) {
                $extras        = Extra::whereIn('id', $extraIds)->get();
                $extrasIds     = $extras->pluck('id')->implode('|');
                $extrasNames   = $extras->pluck('name')->implode('|');
                $extrasPrices  = $extras->pluck('price')->implode('|');
            }


              // Create cart item
            $cart = new Cart();
            if (auth('sanctum')->user() && auth('sanctum')->user()->type == 2) {
                $cart->user_id = auth('sanctum')->user()->id;
                $cart->session_id = "";
            } else {
                $cart->user_id = "";
                $cart->session_id = $sessionId;
            }

            $cart->item_id = $itemdata->id;
            $cart->deal_id = $request->deal_id ?? null;
            $cart->size_id = $request->size_id;
            $cart->crust_id = $request->crust_id;
            $cart->item_name = $request->item_name ?? $itemdata->item_name;
            $cart->item_type = $request->item_type ?? $itemdata->type ?? 1;
            $cart->item_image = $itemdata->item_image ?? null;
            $cart->deal_category_id = $request->deal_category_id ?? null;
            
            $cart->tax = $itemdata->tax ?? 0;

            $cart->item_price = helper::number_format($serverItemPrice);
            $cart->addons_id           = $addonsIds;
            $cart->addons_name         = $addonsNames;
            $cart->addons_price        = $addonsPrices;

            $cart->addons_total_price = isset($addons) ? helper::number_format($addons->sum('price')) : 0;

            $cart->extras_id           = $extrasIds;
            $cart->extras_name         = $extrasNames;
            $cart->extras_price        = $extrasPrices;
            $cart->extras_total_price = isset($extras) ? helper::number_format($extras->sum('price')) : 0;
            $cart->qty = $validated['qty'];
            $cart->buynow = $request->buynow ?? 0;
            // $cart->branch_id = $branchId; // Store branch ID with cart item
            $cart->save();

            $autoAddedItems = BogoAutoAddService::autoAddFreeItems($cart, $branchId);

            // Get cart count
            if (auth('sanctum')->user() && auth('sanctum')->user()->type == 2) {
                $total_count = Cart::where('user_id', auth('sanctum')->user()->id)
                    ->where('buynow', 0)
                    // ->where('branch_id', $branchId)
                    ->count();
            } else {
                $total_count = Cart::where('session_id', $sessionId)
                    ->where('buynow', 0)
                    // ->where('branch_id', $branchId)
                    ->count();
            }

            return response()->json([
                'status' => 1, 
                'message' => trans('messages.success'), 
                'data' => [
                    'cart_count' => $total_count,
                    'item_count' => helper::get_item_cart($itemdata->id),
                    'cart_item_id' => $cart->id,
                    'session_id' => $sessionId
                ], 
                'buynow' => $request->buynow ?? 0
            ], 200);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::info('Add to cart error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
                'session_id' => $sessionId
            ]);

            return response()->json([
                'status' => 0,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'buynow' => $request->buynow ?? 0
            ], 422);
        } catch (\Throwable $th) {
            Log::info('Add to cart error: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString(),
                'request' => $request->all(),
                'session_id' => $sessionId
            ]);
            
            return response()->json([
                'status'  => 0,
                'message' => trans('messages.wrong'),
                'error'   => config('app.debug') ? $th->getMessage() : 'An error occurred',
                'file'    => config('app.debug') ? $th->getFile() : null,
                'line'    => config('app.debug') ? $th->getLine() : null,
                'buynow'  => $request->buynow ?? 0
            ], 500);

        }
    }


    public function addpizzatocart(Request $request)
    {
        // Validate required fields
        $validated = $request->validate([
            'slug' => 'required|string|exists:item,slug',
            'size_id' => 'required|integer|exists:sizes,id',
            'crust_id' => 'required|integer|exists:crusts,id',
            'qty' => 'required|integer|min:1',
            'branch_id' => 'required|integer|exists:branches,id',
            'item_price' => 'required|numeric|min:0',
        ]);

        // Get session ID from header (required for API)
        $sessionId = $request->header('X-Session-Id');
        
        if (!$sessionId) {
            return response()->json([
                'status' => 0,
                'message' => 'Session ID is required. Please provide X-Session-Id header.',
                'buynow' => $request->buynow ?? 0
            ], 400);
        }

        $branchId = $validated['branch_id'];
        
        try {
            // Handle buynow clearance
            if ($request->buynow == 1) {
                if (auth('sanctum')->user() && auth('sanctum')->user()->type == 2) {
                    Cart::where('buynow', 1)->where('user_id', auth('sanctum')->user()->id)->delete();
                } else {
                    Cart::where('buynow', 1)->where('session_id', $sessionId)->delete();
                }
            }
            
            // Process addons
            $addonIds = $request->addons_id;
            $dippings = $request->dippings;

            if ($addonIds !== null) {
                $addonIdsArray = $addonIds;
                
                // Validate addons
                $validAddons = Addons::whereIn('id', $addonIdsArray)->count();
                if ($validAddons != count(array_unique($addonIdsArray))) {
                    return response()->json([
                        'status' => 0,
                        'message' => 'Invalid addons provided.',
                        'buynow' => $request->buynow ?? 0
                    ], 400);
                }

                $addonNames = DB::table('addons')
                    ->whereIn('id', $addonIdsArray)
                    ->orderByRaw('FIELD(id, ' . implode(',', $addonIdsArray) . ')')
                    ->pluck('name');

                $addons_name = $addonNames->implode('| ');
            } else {
                $addons_name = null;
            }

            // Process dippings
            if ($dippings !== null) {
                $dippingName = [];
                $dippingPrice = [];
                $dippingQuantity = [];

                foreach ($dippings as $dipping) {
                    if (!isset($dipping['id']) || !isset($dipping['price']) || !isset($dipping['quantity'])) {
                        return response()->json([
                            'status' => 0,
                            'message' => 'Invalid dipping format. Each dipping must have id, price, and quantity.',
                            'buynow' => $request->buynow ?? 0
                        ], 400);
                    }

                    $side = Sides::find($dipping['id']);
                    if (!$side) {
                        return response()->json([
                            'status' => 0,
                            'message' => 'Invalid dipping ID: ' . $dipping['id'],
                            'buynow' => $request->buynow ?? 0
                        ], 400);
                    }

                    $dippingName[] = $side->name;
                    $dippingPrice[] = $dipping['price'];
                    $dippingQuantity[] = $dipping['quantity'];
                }

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
                    'buynow' => $request->buynow ?? 0
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
                    'buynow' => $request->buynow ?? 0
                ], 400);
            }

            $serverItemPrice = $sizeCrustPrice;

            // Validate deal if provided
            if ($request->has('deal_id') && $request->deal_id) {
                $request->validate([
                    'deal_id' => 'integer|exists:top_deals,id',
                    'deal_category_id' => 'required_if:deal_id,!=,null|integer|exists:deal_categories,id',
                ]);

                $deal = TopDeals::where('id', $request->deal_id)->first();
                
                if ($deal && $deal->deal_type == 3) {
                    $dealCategory = DealCategory::with('dealItem')
                        ->where('id', $request->deal_category_id)
                        ->first();

                    if (!$dealCategory) {
                        return response()->json([
                            'status' => 0,
                            'message' => 'Invalid deal category.',
                            'buynow' => $request->buynow ?? 0
                        ], 400);
                    }

                    $cartQuery = Auth::check() && auth('sanctum')->user()->type == 2
                        ? Cart::where('user_id', Auth::id())
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
                                'status' => 0,
                                'message' => 'Please add the required items to unlock discounted items in this deal.',
                                'buynow' => $request->buynow ?? 0
                            ], 400);
                        }

                        $maxDiscountedAllowed = $totalEligibleSets * ($freeLimits[$dealCategory->id] ?? 0);

                        $existingDiscountedQty = (clone $cartQuery)
                            ->where('deal_id', $deal->id)
                            ->where('deal_category_id', $dealCategory->id)
                            ->sum('qty');

                        if ($existingDiscountedQty + $requestedQty <= $maxDiscountedAllowed) {
                            $serverItemPrice = 0;
                            $request->merge(['is_discounted' => true]);
                        } else {
                            return response()->json([
                                'status' => 0,
                                'message' => 'You have already added the maximum allowed discounted items for this deal. Add more base items to unlock more.',
                                'buynow' => $request->buynow ?? 0
                            ], 400);
                        }
                    }
                }
            }
            
            // Create cart item
            $cart = new Cart();
            if (auth('sanctum')->user() && auth('sanctum')->user()->type == 2) {
                $cart->user_id = auth('sanctum')->user()->id;
                $cart->session_id = "";
            } else {
                $cart->user_id = "";
                $cart->session_id = $sessionId;
            }
            
            $addons_price = $request->addons_price == null ? null : str_replace('|', '| ', $request->addons_price);
            
            $cart->item_id = $itemdata->id;
            $cart->item_name = $request->item_name ?? $itemdata->item_name;
            $cart->deal_id = $request->deal_id ?? null;
            $cart->item_type = $request->item_type ?? $itemdata->type ?? 1;
            $cart->item_image = $request->image_name ?? $itemdata->image ?? null;
            $cart->tax = $itemdata->tax ?? 0;
            $cart->deal_category_id = $request->deal_category_id ?? null;
            $cart->item_price = helper::number_format($serverItemPrice);
            $cart->addons_id = $request->addons_id == null ? null : str_replace('|', '| ', $request->addons_id);
            $cart->addons_name = $addons_name;
            $cart->addons_price = $addons_price;
            $cart->addons_total_price = helper::number_format($request->addons_price == "" ? 0 : array_sum(explode('| ', $addons_price ?? '')));
            $cart->extras_id = $request->extras_id ?? null;
            $cart->extras_name = $request->extras_name ?? null;
            $cart->extras_price = $request->extras_price ?? null;
            $cart->extras_total_price = helper::number_format($request->extras_price == "" ? 0 : array_sum(explode('| ', $request->extras_price ?? '')));
            $cart->dipping_quantity = $dippingQuantity;
            $cart->dipping_name = $dippingName;
            $cart->dipping_price = $dippingPrice;
            $cart->size_id = $validated['size_id'];
            $cart->crust_id = $validated['crust_id'];
            $cart->qty = $validated['qty'];
            $cart->buynow = $request->buynow ?? 0;
            $cart->branch_id = $branchId;
            $cart->save();

            $autoAddedItems = BogoAutoAddService::autoAddFreeItems($cart, $branchId);

            // Get cart count
            if (auth('sanctum')->user() && auth('sanctum')->user()->type == 2) {
                $total_count = Cart::where('user_id', auth('sanctum')->user()->id)
                    ->where('buynow', 0)
                    ->where('branch_id', $branchId)
                    ->count();
            } else {
                $total_count = Cart::where('session_id', $sessionId)
                    ->where('buynow', 0)
                    ->where('branch_id', $branchId)
                    ->count();
            }

            return response()->json([
                'status' => 1, 
                'message' => trans('messages.success'), 
                'data' => [
                    'cart_count' => $total_count,
                    'item_count' => helper::get_item_cart($itemdata->id),
                    'cart_item_id' => $cart->id,
                    'session_id' => $sessionId
                ], 
                'buynow' => $request->buynow ?? 0
            ], 200);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'buynow' => $request->buynow ?? 0
            ], 422);
        } catch (\Throwable $th) {
            Log::error('Add pizza to cart error: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString(),
                'request' => $request->all(),
                'session_id' => $sessionId
            ]);
            
            return response()->json([
                'status' => 0, 
                'message' => trans('messages.wrong'),
                'error' => config('app.debug') ? $th->getMessage() : 'An error occurred',
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

            $cartQuery = Auth::check() && auth('sanctum')->user()->type == 2
                ? Cart::where('user_id', Auth::id())
                : Cart::where('session_id', $sessionId);

            $checkcart = (clone $cartQuery)->where('id', $request->id)->first();

            if (!$checkcart) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cart item not found'
                ], 404);
            }

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

            // Determine cart query for totals
            $cartQuery = Auth::check() && auth('sanctum')->user()->type == 2
                ? Cart::where('user_id', Auth::id())
                : Cart::where('session_id', $sessionId);

            $checkcart = (clone $cartQuery)->where('id', $request->id)->first();

            if (!$checkcart) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cart item not found'
                ], 404);
            }

            $needsAutoAdd = false;

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

            if ($needsAutoAdd) {
                BogoAutoAddService::autoAddFreeItems($checkcart);
            }

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
