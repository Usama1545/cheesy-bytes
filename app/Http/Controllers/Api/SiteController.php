<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Item;
use App\Models\user;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\itemPrice;
use App\Models\PizzaPrice;
use App\Models\ProductSizeCrust;
use App\Models\TopDeals;
use App\Models\Addons;
use App\Helpers\sms_helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\helper;
use App\Models\Category;
use App\Models\AddonsGroup;
use App\Models\Extra;
use App\Models\Slider;
use App\Models\DealCategory;
use App\Helpers\ApiCacheHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Models\PrivacyPolicy;
use App\Models\RefundPolicy;
use App\Models\Aboutus;
use App\Models\TermsCondition;

class SiteController extends Controller
{
    public function branches()
    {
        $branches = Branch::with('delivery_partners')->get();
        return response()->json($branches);
    }

    public function homeItems(Request $request)
    {
        $branchId = $request->branch_id;
        $userId = auth('sanctum')->id();
        
        if (!$branchId) {
            return response()->json([
                'status'  => false,
                'message' => 'branch_id is required'
            ], 400);
        }

        // Use ApiCacheHelper to cache the response
        $response = ApiCacheHelper::remember(
            'home_items', // endpoint name
            1800, // 30 minutes TTL (adjust as needed)
            function () use ($request, $branchId, $userId) {
                $sessionId = $request->header('X-Session-Id');
                
                /* -----------------------------
                    TOP ITEMS
                ----------------------------- */
                $topItemsQuery = Item::with('category_info', 'subcategory_info', 'item_image')
                    ->select(
                        'item.*',
                        DB::raw('COUNT(order_details.item_id) AS item_order_counter'),
                        DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId 
                            THEN COALESCE(item_prices.price, 0) 
                            ELSE 0 END) AS item_price")
                    )
                    ->leftJoin('order_details', 'order_details.item_id', '=', 'item.id')
                    ->leftJoin('item_prices', function ($query) use ($branchId) {
                        $query->on('item_prices.item_id', '=', 'item.id')
                            ->where('item_prices.branch_id', '=', $branchId);
                    })
                    ->where('item.item_status', 1)
                    ->where(function ($query) use ($branchId) {
                        $query->where('item.branch_ids', 'like', "%,$branchId,%")
                            ->orWhere('item.branch_ids', 'like', "$branchId,%")
                            ->orWhere('item.branch_ids', 'like', "%,$branchId")
                            ->orWhere('item.branch_ids', '=', $branchId);
                    })
                    ->groupBy('order_details.item_id', 'item.id');

                if ($userId) {
                    $topItemsQuery
                        ->addSelect(DB::raw('(CASE WHEN favorite.item_id IS NULL THEN 0 ELSE 1 END) AS is_favorite'))
                        ->leftJoin('favorite', function ($query) use ($userId) {
                            $query->on('favorite.item_id', '=', 'item.id')
                                ->where('favorite.user_id', '=', $userId);
                        })
                        ->addSelect(DB::raw('(CASE WHEN cart.item_id IS NULL THEN 0 ELSE 1 END) AS is_cart'))
                        ->leftJoin('cart', function ($query) use ($userId) {
                            $query->on('cart.item_id', '=', 'item.id')
                                ->where('cart.user_id', '=', $userId)
                                ->where('cart.buynow', '=', 0);
                        });
                } else {
                    $topItemsQuery
                        ->addSelect(DB::raw('(CASE WHEN cart.item_id IS NULL THEN 0 ELSE 1 END) AS is_cart'))
                        ->leftJoin('cart', function ($query) use ($sessionId) {
                            $query->on('cart.item_id', '=', 'item.id')
                                ->where('cart.session_id', '=', $sessionId)
                                ->where('cart.buynow', '=', 0);
                        });
                }

                $topItems = $topItemsQuery
                    ->orderByDesc('item_order_counter')
                    ->limit(6)
                    ->get();

                // Return the response structure
                return [
                    'status'        => true,
                    'top_items'     => $topItems,
                    'cached'        => false, // Will be overridden
                    'timestamp'     => now()->toDateTimeString()
                ];
            },
            $request, // Pass the request for parameter-based caching
            $userId   // Pass user ID for user-specific caching
        );

        // Override cached flag to indicate this is fresh from cache
        $response['cached'] = true;
        
        return response()->json($response);
    }

    public function categories(Request $request)
    {
        $branchId = $request->branch_id;

        if (!$branchId) {
            return response()->json([
                'status'  => false,
                'message' => 'branch_id is required'
            ], 400);
        }

        $userId = auth('sanctum')->id();

        // Use ApiCacheHelper to cache categories
        $response = ApiCacheHelper::remember(
            'categories', // endpoint name
            3600, // 1 hour TTL (categories don't change often)
            function () use ($branchId) {
                $categories = Category::select('id', 'category_name', 'slug', 'image')
                    ->where(function ($q) use ($branchId) {
                        $q->where('branch_ids', $branchId)
                        ->orWhere('branch_ids', 'like', "$branchId,%")
                        ->orWhere('branch_ids', 'like', "%,$branchId")
                        ->orWhere('branch_ids', 'like', "%,$branchId,%");
                    })
                    ->where('is_available', 1)
                    ->get();

                return [
                    'status'        => true,
                    'top_items'     => $categories,
                    'cached'        => false,
                    'timestamp'     => now()->toDateTimeString()
                ];
            },
            $request, // Pass request for parameter-based caching
            $userId   // User-specific caching (optional for categories)
        );

        // Override cached flag
        $response['cached'] = true;
        
        return response()->json($response);
    }

    public function checklogin(Request $request)
    {
        $useOtp = helper::checkaddons('otp');
        $isSandbox = env('Environment') === 'sendbox';

        /* --------------------------------------------------
            OTP LOGIN FLOW
        -------------------------------------------------- */
        if ($useOtp) {
            $user = User::where('mobile', $request->mobile)
                ->where('is_deleted', 2)
                ->where('type', 2)
                ->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid user',
                ], 404);
            }

            if ($user->is_available != 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'User is blocked',
                ], 403);
            }

            $otp = rand(100000, 999999);
            $sent = sms_helper::verificationsms($user->mobile, $otp);

            if ($sent != 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'OTP sending failed',
                ], 500);
            }

            $user->otp = $otp;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'OTP sent',
                'mobile' => $request->mobile,
                'otp' => $isSandbox ? $otp : null, // sandbox only
            ]);
        }

        /* --------------------------------------------------
            PASSWORD LOGIN FLOW
        -------------------------------------------------- */
        $user = User::where('email', $request->email)
            ->where('type', 2)
            ->where('is_deleted', 2)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password',
            ], 401);
        }

        if ($user->is_available != 1) {
            return response()->json([
                'status' => false,
                'message' => 'User is blocked',
            ], 403);
        }

        /* --------------------------------------------------
            USER EMAIL NOT VERIFIED → SEND OTP
        -------------------------------------------------- */
        if ($user->is_verified != 1) {

            $otp = rand(100000, 999999);
            $emailSent = helper::verificationemail($user->email, $otp);

            if ($emailSent != 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email sending failed',
                ], 500);
            }

            $user->otp = $otp;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Verification OTP sent to email',
                'email' => $user->email,
                'otp' => $isSandbox ? $otp : null,
            ]);
        }

        /* --------------------------------------------------
            LOGIN SUCCESS → ISSUE API TOKEN
        -------------------------------------------------- */
        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function categoryItems(Request $request, $slug)
    {
        $branchId = $request->branch_id;
        $userId = auth('sanctum')->id();

        if (!$branchId) {
            return response()->json([
                'status'  => false,
                'message' => 'branch_id is required'
            ], 400);
        }

        /* -----------------------------------------------------
            LEVEL 1: CACHE BASE DATA (SHARED BETWEEN ALL USERS)
        ------------------------------------------------------ */
        $baseCacheKey = "category_items_base_{$slug}_branch_{$branchId}";
        $baseData = Cache::remember($baseCacheKey, 3600, function () use ($slug, $branchId) {
            $category = Category::where('slug', $slug)
                ->where('is_available', 1)
                ->where('is_deleted', 2)
                ->first();

            if (!$category) {
                return null;
            }

            $subcategories = Subcategory::where('cat_id', $category->id)
                ->where('is_available', 1)
                ->where('is_deleted', 2)
                ->orderBy('reorder_id')
                ->get();

            $baseItems = Item::with('category_info', 'subcategory_info', 'item_image')
                ->select(
                    'item.*',
                    DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId 
                        THEN COALESCE(item_prices.price, 0) 
                        ELSE 0 END) AS item_price")
                )
                ->leftJoin('item_prices', function ($query) use ($branchId) {
                    $query->on('item_prices.item_id', '=', 'item.id')
                        ->where('item_prices.branch_id', '=', $branchId);
                })
                ->where('item.item_status', 1)
                ->where('item.cat_id', $category->id)
                ->where(function ($query) use ($branchId) {
                    $query->where('item.branch_ids', 'like', "%,$branchId,%")
                        ->orWhere('item.branch_ids', 'like', "$branchId,%")
                        ->orWhere('item.branch_ids', 'like', "%,$branchId")
                        ->orWhere('item.branch_ids', '=', $branchId);
                })
                ->groupBy('item.id')
                ->orderBy('item.reorder_id')
                ->get();

            return [
                'category' => $category,
                'subcategories' => $subcategories,
                'baseItems' => $baseItems,
                'itemIds' => $baseItems->pluck('id')->toArray()
            ];
        });

        if (!$baseData) {
            return response()->json([
                'status'  => false,
                'message' => 'Category not found',
            ], 404);
        }

        /* -----------------------------------------------------
            LEVEL 2: GET USER-SPECIFIC DATA
        ------------------------------------------------------ */
        $sessionId = $request->header('X-Session-Id');
        $itemIds = $baseData['itemIds'];
        
        if ($userId) {
            // Cache user favorites for 5 minutes
            $favoriteKey = "user_{$userId}_favorites_" . md5(implode(',', $itemIds));
            $favoriteIds = Cache::remember($favoriteKey, 300, function () use ($userId, $itemIds) {
                return DB::table('favorite')
                    ->where('user_id', $userId)
                    ->whereIn('item_id', $itemIds)
                    ->pluck('item_id')
                    ->toArray();
            });

            // Cache user cart items for 5 minutes
            $cartKey = "user_{$userId}_cart_" . md5(implode(',', $itemIds));
            $cartItemIds = Cache::remember($cartKey, 300, function () use ($userId, $itemIds) {
                return DB::table('cart')
                    ->where('user_id', $userId)
                    ->where('buynow', 0)
                    ->whereIn('item_id', $itemIds)
                    ->pluck('item_id')
                    ->toArray();
            });
        } else {
            if ($sessionId) {
                $cartKey = "guest_{$sessionId}_cart_" . md5(implode(',', $itemIds));
                $cartItemIds = Cache::remember($cartKey, 300, function () use ($sessionId, $itemIds) {
                    return DB::table('cart')
                        ->where('session_id', $sessionId)
                        ->where('buynow', 0)
                        ->whereIn('item_id', $itemIds)
                        ->pluck('item_id')
                        ->toArray();
                });
            } else {
                $cartItemIds = [];
            }
            $favoriteIds = [];
        }

        /* -----------------------------------------------------
            ENRICH AND GROUP ITEMS
        ------------------------------------------------------ */
        $enrichedItems = $baseData['baseItems']->map(function ($item) use ($favoriteIds, $cartItemIds) {
            $item->is_favorite = in_array($item->id, $favoriteIds) ? 1 : 0;
            $item->is_cart = in_array($item->id, $cartItemIds) ? 1 : 0;
            return $item;
        });

        $groupedItems = $enrichedItems
            ->sortBy(fn($item) => $item->subcategory_info->reorder_id ?? PHP_INT_MAX)
            ->groupBy(fn($item) =>
                $item->subcategory_info->subcategory_name 
                ?? $item->category_info->category_name
            );

        /* -----------------------------------------------------
            API RESPONSE
        ------------------------------------------------------ */
        return response()->json([
            'status'        => true,
            'category'      => $baseData['category'],
            'subcategories' => $baseData['subcategories'],
            'items'         => $groupedItems,
            'cache_info'    => [
                'base_cached' => true,
                'user_cached' => true,
                'response_time' => microtime(true) - LARAVEL_START
            ]
        ]);
    }
    public function ItemDetails(Request $request, $slug) 
    {
        $user_id = auth('sanctum')->user()->id ?? null;
        $branchId = $request->branch_id;
        $deal_id = $request->dealId;
        $deal_category_id = $request->dealCategoryId;
        $size_ids = $request->size_ids ? explode(',', $request->size_ids) : [];

        if (!$branchId) {
            return response()->json([
                'status'  => false,
                'message' => 'branch_id is required'
            ], 400);
        }

        // Common query for item info
        $iteminfo = Item::with(['subcategory_info', 'category_info', 'item_image'])
            ->select(
                'item.*',
                DB::raw('(CASE WHEN favorite.item_id IS NULL THEN 0 ELSE 1 END) AS is_favorite'),
                DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId 
                    THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price")
            )
            ->leftJoin('favorite', function ($query) use ($user_id) {
                $query->on('favorite.item_id', '=', 'item.id')
                      ->where('favorite.user_id', '=', $user_id);
            })
            ->leftJoin('item_prices', function ($query) use ($branchId) {
                $query->on('item_prices.item_id', '=', 'item.id')
                      ->where('item_prices.branch_id', '=', $branchId);
            })
            ->where('item.slug', $slug)
            ->where('item.item_status', 1)
            ->groupBy('item.id')   // 🔥 REQUIRED
            ->first();

            

        if (!$iteminfo) {
            return response()->json([
                'status'  => false,
                'message' => 'Item not found'
            ], 404);
        }

        // Check if item is pizza
        $is_pizza = ($iteminfo->category_info && $iteminfo->category_info->slug == 'pizza');
        
        // Handle deal pricing
        $final_price = $iteminfo->item_price ?? $iteminfo->prices;
        $dealprice = null;

        if ($deal_id) {
            $topDeal = TopDeals::find($deal_id);

            if ($topDeal) {
                $product_id = $topDeal->product_id;
                if ($is_pizza && !empty($size_ids)) {
                    
                    // Pizza deal pricing logic
                    if ($topDeal->deal_type == 3 && $deal_category_id) {
                        $deal_category = DealCategory::where('id', $deal_category_id)->first();
                        
                        // Get pizza prices for the item
                        $pizzaPrices = PizzaPrice::where('item_id', $iteminfo->id)
                            ->where('branch_id', $branchId)
                            ->get();
                        
                        // Calculate base price from pizza prices
                        if (!$pizzaPrices->isEmpty()) {
                            $dealPrice = $pizzaPrices
                                ->filter(function ($price) use ($size_ids) {
                                    return in_array($price->size_id, $size_ids);
                                })
                                ->sortBy('price')
                                ->first();
                            
                            $basePrice = $dealPrice ? $dealPrice->price : $final_price;
                        } else {
                            $basePrice = $final_price;
                        }
                        
                        // Apply deal pricing
                        if (!$deal_category || !$deal_category->is_free) {
                            $dealprice = $basePrice;
                        } else {
                            if ($topDeal->offer_type == 1) {
                                $dealprice = max(0, $basePrice - $topDeal->offer_amount);
                            } elseif ($topDeal->offer_type == 2) {
                                $dealprice = $basePrice - ($basePrice * ($topDeal->offer_amount / 100));
                            } else {
                                $dealprice = $basePrice;
                            }
                        }
                    } else {
                        // Regular pizza deal pricing
                        $dealprice = PizzaPrice::where('item_id', $product_id)
                            ->where('branch_id', $branchId)
                            ->whereIn('size_id', $size_ids)
                            ->orderBy('price', 'asc')
                            ->value('price');
                            
                        if (!$dealprice) {
                            $dealprice = ItemPrice::where('item_id', $product_id)
                                ->where('branch_id', $branchId)
                                ->value('price');
                        }
                    }
                } else {
                    // Non-pizza deal pricing
                    $price = ItemPrice::where('item_id', $product_id)
                        ->where('branch_id', $branchId)
                        ->value('price');
                        
                    if ($price) {
                        $final_price = $price;
                    }
                    
                    
                    if ($topDeal->deal_type == 3) {
                                  

                        $dealItem = \App\Models\DealItem::where('deal_id', $topDeal->id)
                            ->where('item_id', $iteminfo->id)
                            ->first();

                        if ($dealItem) {
                            $dealCategory = \App\Models\DealCategory::where('id', $deal_category_id)
                                ->first();

                            if ($dealCategory && $dealCategory->is_free == 1) {
                                if ($topDeal->offer_type == 1) {
                                    $price = max(0, $price - $topDeal->offer_amount);
                                } else {
                                    $price = $price - ($price * ($topDeal->offer_amount / 100));
                                }
                            }
                        }
                        $final_price = $price;
                    }
                }
            }
        }

        // Prepare pizza-specific data if it's a pizza
        $sizes = [];
        $pizza_crusts = [];
        
        if ($is_pizza) {
            // Get pizza prices
            $prices = PizzaPrice::where('item_id', $iteminfo->id)
                ->where('branch_id', $branchId)
                ->get();
            
            // Get crusts
            $crustsQuery = ProductSizeCrust::where('item_id', $iteminfo->id);
            if (!empty($size_ids)) {
                $crustsQuery->whereIn('size_id', $size_ids);
            }
            $crusts = $crustsQuery->get();
            
            $sizes = $prices->map(function ($price) use ($crusts, $dealprice) {
                $sizeCrusts = $crusts->where('size_id', $price->size_id);
                
                // Only include size if it has crusts
                if ($sizeCrusts->isNotEmpty()) {
                    return [
                        'id' => $price->size_id,
                        'name' => $price->size->name ?? null,
                        'label' => $price->size->label ?? null,
                        'price' => $dealprice ?? $price->price,
                        'crusts' => $sizeCrusts->map(function ($crust) {
                            return [
                                'id' => $crust->crust_id,
                                'name' => $crust->crust->name ?? null,
                                'price' => $crust->price,
                            ];
                        })->values()->toArray(),
                    ];
                }
                
                return null;
            })
            ->filter() // Remove null entries (sizes without crusts)
            ->values()
            ->toArray();
        }

        // Get addons groups
        $addons_group = AddonsGroup::select('id', 'name', 'selection_type', 'selection_count', 'min_count', 'max_count')
            ->whereIn('id', explode(',', $iteminfo->addons_id))
            ->where('is_deleted', 2)
            ->where('is_available', 1)
            ->orderBy('reorder_id')
            ->get();

        // Get addons with branch filtering
        $addons = Addons::select('id', 'addongroup_id', 'name', 'price')
            ->where('is_available', 1)
            ->where(function ($query) use ($branchId, $is_pizza) {
                // For pizza, use the branch_id filtering from pizzadetails function
                if ($is_pizza) {
                    $query->where('branch_ids', 'like', "%,$branchId,%")
                        ->orWhere('branch_ids', 'like', "$branchId,%")
                        ->orWhere('branch_ids', 'like', "%,$branchId")
                        ->orWhere('branch_ids', '=', $branchId);
                } else {
                    // For non-pizza items, get all available addons
                }
            })
            ->orderBy('reorder_id')
            ->get();

        // Filter addons groups based on available addons
        $addons_group = $addons_group->filter(function ($group) use ($addons, $is_pizza) {
            $group->availableAddons = $addons->where('addongroup_id', $group->id);
            if ($is_pizza) {
                return $group->availableAddons->isNotEmpty();
            }
            return true;
        })->values();

        // Get extras
        $extras = Extra::where('item_id', $iteminfo->id)
            ->where(function ($query) use ($branchId) {
                $query->where('branch_id', 'like', "%,$branchId,%")
                    ->orWhere('branch_id', 'like', "$branchId,%")
                    ->orWhere('branch_id', 'like', "%,$branchId")
                    ->orWhere('branch_id', '=', $branchId);
            })
            ->get();
            

        // Prepare response data
        $itemdata = [
            "id"              => $iteminfo->id,
            "slug"            => $iteminfo->slug,
            "item_name"       => $iteminfo->item_name,
            "price"           => $dealprice ?? $final_price,
           "tax"             => $iteminfo->tax,
            "image"           => $iteminfo->item_image->image_url,
            "image_name"      => optional($iteminfo->item_image)->image_name,
            "is_favorite"     => $iteminfo->is_favorite,
            "is_pizza"        => $is_pizza,
            "addons_group"    => $addons_group,
            "extras"          => $extras,
        ];

        // Add pizza-specific data if it's a pizza
        if ($is_pizza) {
            $itemdata['sizes'] = $sizes;
            $itemdata['pizza_details'] = [
                'category_id' => $iteminfo->category_info->id ?? null,
                'category_name' => $iteminfo->category_info->name ?? null,
                'category_slug' => $iteminfo->category_info->slug ?? null,
            ];
        }

        return response()->json([
            'status'   => true,
            'item'     => $itemdata,
        ]);
    }

    public function pizzadetails($slug, Request $request)
    {
        $branchId = $request->branch_id;
        $item = Item::with('category_info')->where('slug', $slug)->first();
        
        if (!$item || !$item->id || $item->category_info->slug != 'pizza') {
            return response()->json([
                'status' => false,
                'message' => 'Item not found'
            ]);
        }

        $id = $item->id;
        $dealprice = null;

        $getitemdata = Item::with('category_info', 'subcategory_info', 'item_images', 'pizzaPrices', 'item_image')
            ->select('item.*',
                DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"))
            ->leftJoin('item_prices', function ($query) use ($branchId) {
                $query->on('item_prices.item_id', '=', 'item.id')
                    ->where('item_prices.branch_id', '=', $branchId);
            })
            ->groupBy('item.id')
            ->where('item.slug', $slug)
            ->where('item.item_status', '1')
            ->first();

            $getitemdata['addons_group'] = AddonsGroup::select('id', 'name', 'selection_type', 'selection_count', 'min_count', 'max_count')
                ->whereIn('id', explode(',', $getitemdata->addons_id))
                ->where('is_deleted', 2)
                ->where('is_available', 1)
                ->orderBy('reorder_id')
                ->get();

            // Addons
            $addons = Addons::select('id', 'addongroup_id', 'name', 'price')
                ->where('is_deleted', 2)
                ->where('is_available', 1)
                ->where(function ($query) use ($branchId) {
                    $query->where('branch_ids', 'like', "%,$branchId,%")
                        ->orWhere('branch_ids', 'like', "$branchId,%")
                        ->orWhere('branch_ids', 'like', "%,$branchId")
                        ->orWhere('branch_ids', '=', $branchId);
                })
                ->orderBy('reorder_id')
                ->get();

            $getitemdata['addons_group'] = $getitemdata['addons_group']
                ->filter(function ($group) use ($addons) {

                    // Convert collection → array
                    $group->availableAddons = $addons
                        ->where('addongroup_id', $group->id)
                        ->values()
                        ->toArray();

                    return !empty($group->availableAddons);
                })
                ->values();
            
        // Extras
        $getitemdata['extras'] = Extra::where('item_id', $getitemdata->id)
            ->where(function ($query) use ($branchId) {
                $query->where('branch_id', 'like', "%,$branchId,%")
                    ->orWhere('branch_id', 'like', "$branchId,%")
                    ->orWhere('branch_id', 'like', "%,$branchId")
                    ->orWhere('branch_id', '=', $branchId);
            })->get();

        // Handle deal pricing
        $sizeIds = [];
        if (isset($request['dealId']) && isset($request['sizeId'])) {
            $topDeal = TopDeals::where('id', $request->dealId)->first();

            if (!$topDeal) {
                return response()->json(['error' => 'Invalid deal ID'], 400);
            }

            $product_id = $topDeal->product_id;
            $deal_type = $topDeal->deal_type;
            $sizeIds = explode(',', $request['sizeId']);

            if ($deal_type == 3) {
                $deal_category = DealCategory::where('id', $request->dealCategoryId)->first();

                // Calculate base price
                if (!$getitemdata->pizzaPrices->isEmpty()) {
                    $dealPrice = $getitemdata->pizzaPrices
                        ->filter(function ($price) use ($sizeIds, $branchId) {
                            return in_array($price->size_id, $sizeIds) && $price->branch_id == $branchId;
                        })
                        ->sortBy('price')
                        ->first();

                    $basePrice = $dealPrice ? $dealPrice->price : $getitemdata->item_price;
                } else {
                    $basePrice = $getitemdata->item_price;
                }

                // Apply deal pricing
                if (!$deal_category || !$deal_category->is_free) {
                    $dealprice = $basePrice;
                } else {
                    if ($topDeal->offer_type == 1) {
                        $dealprice = max(0, $basePrice - $topDeal->offer_amount);
                    } elseif ($topDeal->offer_type == 2) {
                        $dealprice = $basePrice - ($basePrice * ($topDeal->offer_amount / 100));
                    } else {
                        $dealprice = $basePrice;
                    }
                }
            } else {
                $dealprice = PizzaPrice::where('item_id', $product_id)
                    ->where('branch_id', $branchId)
                    ->whereIn('size_id', $sizeIds)
                    ->orderBy('price', 'asc')
                    ->value('price');

                if (!$dealprice) {
                    $dealprice = ItemPrice::where('item_id', $product_id)
                        ->where('branch_id', $branchId)
                        ->value('price');
                }
            }
        }

        $crustsQuery = ProductSizeCrust::where('item_id', $id);
        if (!empty($sizeIds)) {
            $crustsQuery->whereIn('size_id', $sizeIds);
        }
        $crusts = $crustsQuery->get();

        $prices = PizzaPrice::where('item_id', $id)->where('branch_id', $branchId)->get();

        $sizes = $prices->map(function ($price) use ($crusts, $dealprice) {
            $sizeCrusts = $crusts->where('size_id', $price->size_id);
            
            return [
                'id' => $price->size_id,
                'name' => $price->size->name ?? null, // Assuming relationship with Size model
                'label' => $price->size->label ?? null, // Assuming relationship with Size model
                'price' => $dealprice ?? $price->price,
                'crusts' => $sizeCrusts->map(function ($crust) {
                    return [
                        'id' => $crust->crust_id,
                        'name' => $crust->crust->name ?? null, // Assuming relationship with Crust model
                        'price' => $crust->price,
                    ];
                })->values()->toArray(),
            ];
        })->values()->toArray();

        $response = [
            'item_detail' => $getitemdata,
            'sizes' => $sizes // Changed from 'crust_data' to 'sizes'
        ];

        return ['response' => $response]; // Fixed typo: 'responce' to 'response'
    }

    public function deals(Request $request)
    {
        $userId = auth('sanctum')->id();
        $branchId = $request->branch_id;

        if (!$branchId) {
            return response()->json([
                'status' => false,
                'message' => 'branch_id is required'
            ], 400);
        }

        // Use ApiCacheHelper to cache the response
        $response = ApiCacheHelper::remember(
            'deals', // endpoint name
            300, // 5 minutes TTL (deals change frequently due to time constraints)
            function () use ($request, $branchId, $userId) {
                $sessionId = $userId ?? $request->header('X-Session-Id');
                $currentDateTime = now();

                // Get deals without cart join first (for better caching)
                $getsearchitems = TopDeals::with(['product.item_image'])
                    ->join('item', 'top_deals.product_id', '=', 'item.id')
                    ->leftJoin('item_prices', function ($query) use ($branchId) {
                        $query->on('item_prices.item_id', '=', 'item.id')
                            ->where('item_prices.branch_id', '=', $branchId);
                    })
                    ->where(function ($query) use ($currentDateTime) {
                        $query->where('start_date', '<=', $currentDateTime->toDateString())
                            ->where('end_date', '>=', $currentDateTime->toDateString());
                    })
                    ->where(function ($query) use ($currentDateTime) {
                        $query->where('start_time', '<=', $currentDateTime->toTimeString())
                            ->where('end_time', '>=', $currentDateTime->toTimeString());
                    })
                    ->where(function ($query) use ($branchId) {
                        $query->where('item.branch_ids', 'like', "%,$branchId,%")
                            ->orWhere('item.branch_ids', 'like', "$branchId,%")
                            ->orWhere('item.branch_ids', 'like', "%,$branchId")
                            ->orWhere('item.branch_ids', '=', $branchId);
                    })
                    ->select(
                        'top_deals.*',
                        'top_deals.id as deal_id',
                        'item_prices.price as dealPrice',
                        'item.id as item_id' // Add item_id for cart lookup
                    )
                    ->groupBy('item.id')
                    ->get();

                // Get cart items separately for better cache reuse
                $itemIds = $getsearchitems->pluck('item_id')->toArray();
                $cartItemIds = [];
                
                if ($sessionId) {
                    if ($userId) {
                        // Cache user cart items for 2 minutes
                        $cartKey = "user_{$userId}_deals_cart_" . md5(implode(',', $itemIds));
                        $cartItemIds = Cache::remember($cartKey, 120, function () use ($userId, $itemIds) {
                            return DB::table('cart')
                                ->where('user_id', $userId)
                                ->where('buynow', 0)
                                ->whereIn('item_id', $itemIds)
                                ->pluck('item_id')
                                ->toArray();
                        });
                    } else {
                        // Cache guest cart items for 2 minutes
                        $cartKey = "guest_{$sessionId}_deals_cart_" . md5(implode(',', $itemIds));
                        $cartItemIds = Cache::remember($cartKey, 120, function () use ($sessionId, $itemIds) {
                            return DB::table('cart')
                                ->where('session_id', $sessionId)
                                ->where('buynow', 0)
                                ->whereIn('item_id', $itemIds)
                                ->pluck('item_id')
                                ->toArray();
                        });
                    }
                }

                // Map the deals with cart status
                $mapped = $getsearchitems->map(function ($deal) use ($cartItemIds) {
                    $product = $deal->product;
                    $image   = $product?->item_image?->image_url ?? null;

                    return [
                        'deal_id'      => $deal->deal_id,
                        'item_id'      => $deal->item_id,
                        'deal_type'    => $deal->deal_type,
                        'title'        => $deal->title,
                        'description'  => $deal->description,
                        'start_date'   => $deal->start_date,
                        'end_date'     => $deal->end_date,
                        'start_time'   => $deal->start_time,
                        'end_time'     => $deal->end_time,
                        'image'        => $image,
                        'dealPrice'    => $deal->dealPrice,
                        'in_cart'      => in_array($deal->item_id, $cartItemIds),

                        'meta' => [
                            'is_flat'      => $deal->deal_type == 1,
                            'is_selective' => $deal->deal_type == 2,
                            'is_bogo'      => $deal->deal_type == 3,
                            'is_bmsm'      => $deal->deal_type == 4,
                        ],

                        'size_id' => $deal->deal_type == 2 ? ($deal->size_id ?? null) : null
                    ];
                });

                return [
                    'status' => true,
                    'response' => $mapped,
                    'cached' => false,
                    'timestamp' => now()->toDateTimeString()
                ];
            },
            $request, // Pass the request for parameter-based caching
            $userId   // Pass user ID for user-specific caching
        );

        // Override cached flag
        $response['cached'] = true;
        
        return response()->json($response);
    }

    public function sliders(Request $request)
    {
        $branchId = $request->branch_id;
        $userId = auth('sanctum')->id();

        if (!$branchId) {
            return response()->json([
                'status' => false,
                'message' => 'branch_id is required'
            ], 400);
        }

        // Use ApiCacheHelper to cache the response
        $response = ApiCacheHelper::remember(
            'sliders', // endpoint name
            7200, // 2 hours TTL (sliders don't change often)
            function () use ($branchId) {
                $sliders = Slider::with('item_info', 'category_info')
                    ->where('branch_id', $branchId)
                    ->where('is_available', 1)
                    ->orderByDesc('id')
                    ->get()
                    ->map(function ($slider) {
                        return [
                        'id' => $slider->id,
                        'image' => helper::image_path($slider->mobile_image) ?? helper::image_path($slider->image),
                        'title' => $slider->title ?? null,
                        'description' => $slider->description ?? null,
                        'link_type' => $slider->link_type ?? null,
                        'item_id' => $slider->item_info->id ?? null,
                        'category_id' => $slider->category_info->id ?? null,
                        'external_link' => $slider->external_link ?? null,
                        ];
                    });

                return [
                    'status' => true,
                    'data' => $sliders,
                    'cached' => false,
                    'timestamp' => now()->toDateTimeString()
                ];
            },
            $request, // Pass the request
            $userId   // User ID (though sliders are usually the same for all users)
        );

        // Override cached flag
        $response['cached'] = true;
        
        return response()->json($response);
    }
    
    
    public function privacypolicy(Request $request)
    {
        $getprivacypolicy = PrivacyPolicy::first();
        return response()->json($getprivacypolicy);
    }

     public function aboutus(Request $request)
    {
        $getaboutus = Aboutus::first();
        return response()->json($getaboutus);
    }

     public function refundpolicy(Request $request)
    {
        $getrefundpolicy = RefundPolicy::first();
        return response()->json($getrefundpolicy);
    }
    
    
    public function termsconditions(Request $request)
    {
        $gettermscondition = TermsCondition::first();
        return response()->json($gettermscondition);
    }
}