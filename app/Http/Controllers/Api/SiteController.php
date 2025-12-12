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
use Illuminate\Support\Facades\Hash;

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
        $user = auth('sanctum')->user();
        $userId = auth('sanctum')->user()->id ?? null;
        // dd($userId);
        if (!$branchId) {
            return response()->json([
                'status'  => false,
                'message' => 'branch_id is required'
            ], 400);
        }

        $sessionId = $request->header('X-Session-Id'); // optional fallback for guests

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
            ->orderByDesc('item_order_counter')->limit(6)   // or 8
            ->get();

        return response()->json([
            'status'        => true,
            'top_items'     => $topItems,
        ]);
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

        $categories = Category::select('id', 'category_name', 'slug', 'image')->where('branch_ids', 'like', "%,$branchId,%")->where('is_available',1)->get();

        return response()->json([
            'status'        => true,
            'top_items'     => $categories,
        ]);
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

        if (!$branchId) {
            return response()->json([
                'status'  => false,
                'message' => 'branch_id is required'
            ], 400);
        }

        $userId    = auth('sanctum')->user()->id;
        $sessionId = $request->header('X-Session-Id'); // guest cart fallback

        /* -----------------------------------------------------
        FETCH CATEGORY
        ------------------------------------------------------ */
        $category = Category::where('slug', $slug)
            ->where('is_available', 1)
            ->where('is_deleted', 2)
            ->first();

        if (!$category) {
            return response()->json([
                'status'  => false,
                'message' => 'Category not found',
            ], 404);
        }

        /* -----------------------------------------------------
        FETCH SUBCATEGORIES
        ------------------------------------------------------ */
        $subcategories = Subcategory::where('cat_id', $category->id)
            ->where('is_available', 1)
            ->where('is_deleted', 2)
            ->orderBy('reorder_id')
            ->get();

        /* -----------------------------------------------------
        BASE QUERY FOR ITEMS
        ------------------------------------------------------ */
        $itemsQuery = Item::with('category_info', 'subcategory_info', 'item_image')
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
            ->orderBy('item.reorder_id');

        /* -----------------------------------------------------
        USER-SPECIFIC FIELDS (favorite, cart)
        ------------------------------------------------------ */
        if ($userId) {
            $itemsQuery
                ->addSelect(DB::raw('(CASE WHEN favorite.item_id IS NULL THEN 0 ELSE 1 END) AS is_favorite'))
                ->leftJoin('favorite', function ($q) use ($userId) {
                    $q->on('favorite.item_id', '=', 'item.id')
                    ->where('favorite.user_id', '=', $userId);
                })
                ->addSelect(DB::raw('(CASE WHEN cart.item_id IS NULL THEN 0 ELSE 1 END) AS is_cart'))
                ->leftJoin('cart', function ($q) use ($userId) {
                    $q->on('cart.item_id', '=', 'item.id')
                    ->where('cart.user_id', '=', $userId)
                    ->where('cart.buynow', 0);
                });
        } else {
            $itemsQuery
                ->addSelect(DB::raw('(CASE WHEN cart.item_id IS NULL THEN 0 ELSE 1 END) AS is_cart'))
                ->leftJoin('cart', function ($q) use ($sessionId) {
                    $q->on('cart.item_id', '=', 'item.id')
                    ->where('cart.session_id', '=', $sessionId)
                    ->where('cart.buynow', 0);
                });
        }

        $items = $itemsQuery->get();

        /* -----------------------------------------------------
        GROUP ITEMS BY SUBCATEGORY
        ------------------------------------------------------ */
        $groupedItems = $items
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
            'category'      => $category,
            'subcategories' => $subcategories,
            'items'         => $groupedItems,
        ]);
    }

    public function ItemDetails(Request $request, $slug) {
        $user_id  = auth('sanctum')->user()->id;
        $branchId = $request->branch_id;

        if (!$branchId) {
            return response()->json([
                'status'  => false,
                'message' => 'branch_id is required'
            ], 400);
        }

        $iteminfo = Item::with(['subcategory_info', 'category_info', 'item_image'])
            ->select(
                'item.*',
                DB::raw('(CASE WHEN favorite.item_id IS NULL THEN 0 ELSE 1 END) AS is_favorite'),
                DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId 
                        THEN COALESCE(item_prices.price, 0) 
                        ELSE 0 END) AS item_price")
            )
            ->leftJoin('favorite', function ($query) use ($user_id) {
                $query->on('favorite.item_id', '=', 'item.id')
                    ->where('favorite.user_id', '=', $user_id);
            })
            ->leftJoin('item_prices', function ($query) use ($branchId) {
                $query->on('item_prices.item_id', '=', 'item.id')
                    ->where('item_prices.branch_id', '=', $branchId);
            })
            ->where('item.slug', $request->slug)
            ->where('item.item_status', 1)
            ->first();

        if (!$iteminfo) {
            return response()->json([
                'status'  => false,
                'message' => 'Item not found'
            ], 404);
        }

        // Deal price override
        if ($request->deal_id) {
            $topDeal = TopDeals::find($request->deal_id);
            if ($topDeal) {
                $product_id = $topDeal->product_id;
                $price = ItemPrice::where('item_id', $product_id)
                    ->where('branch_id', $branchId)
                    ->value('price');
            }
        }

        $addons_group = AddonsGroup::select('id', 'name', 'selection_type', 'selection_count', 'min_count', 'max_count')
            ->whereIn('id', explode(',', $iteminfo->addons_id))
            ->where('is_deleted', 2)
            ->where('is_available', 1)
            ->orderBy('reorder_id')
            ->get();

        $addons = Addons::select('id', 'addongroup_id', 'name', 'price')
            ->where('is_deleted', 2)
            ->where('is_available', 1)
            ->orderBy('reorder_id')
            ->get();

        $extras = Extra::where('item_id', $iteminfo->id)
            ->where(function ($query) use ($branchId) {
                $query->where('branch_id', 'like', "%,$branchId,%")
                    ->orWhere('branch_id', 'like', "$branchId,%")
                    ->orWhere('branch_id', 'like', "%,$branchId")
                    ->orWhere('branch_id', '=', $branchId);
            })
            ->get();

        foreach ($addons_group as $group) {
            $group->availableAddons = $addons->where('addongroup_id', $group->id)->values();
        }

        $itemdata = [
            "id"              => $iteminfo->id,
            "slug"            => $iteminfo->slug,
            "item_name"       => $iteminfo->item_name,
            "item_type"       => $iteminfo->item_type,
            "item_type_image" => $iteminfo->item_type == 1
                                    ? helper::image_path("veg.svg")
                                    : helper::image_path("nonveg.svg"),
            "price"           => $price ?? $iteminfo->item_price ?? $iteminfo->prices,
            "video_url"       => $iteminfo->video_url,
            "is_top_deals"    => $iteminfo->is_top_deals,
            "tax"             => $iteminfo->tax,
            "image_name"      => optional($iteminfo->item_image)->image_name,
            "is_favorite"     => $iteminfo->is_favorite,
            "addons_group"    => $addons_group,
            "addons"          => $addons,
            "extras"          => $extras,
        ];

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
        $user_id = auth('sanctum')->user()->id;
        $branchId = $request->branch_id;

        $sessionId = $user_id ?? $request->header('X-Session-Id');
        $currentDateTime = now();


        $getsearchitems = TopDeals::with(['product.item_image'])
            ->join('item', 'top_deals.product_id', '=', 'item.id')
            ->leftJoin('cart', function ($query) use ($sessionId) {
                $query->on('cart.item_id', '=', 'item.id')
                    ->where('cart.user_id', '=', $sessionId)
                    ->where('cart.buynow', '=', '0');
            })
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
                'item_prices.price as dealPrice'
            )
            ->groupBy('item.id') // Ensuring each item appears only once
            ->get();

            $mapped = $getsearchitems->map(function ($deal) {

                $product = $deal->product;
                $image   = $product?->item_image?->image_url ?? null;

                // Final unified structure
                return [
                    'deal_id'      => $deal->deal_id,
                    'deal_type'    => $deal->deal_type,
                    'title'        => $deal->title,
                    'description'  => $deal->description,
                    'start_date'   => $deal->start_date,
                    'end_date'     => $deal->end_date,
                    'start_time'   => $deal->start_time,
                    'end_time'     => $deal->end_time,
                    'image'        => $image,
                    'dealPrice'    => $deal->dealPrice,

                    'meta' => [
                        'is_flat'      => $deal->deal_type == 1,
                        'is_selective' => $deal->deal_type == 2,
                        'is_bogo'      => $deal->deal_type == 3,
                        'is_bmsm'      => $deal->deal_type == 4,
                    ],

                    // Selective → Only return size_id
                    'size_id' => $deal->deal_type == 2 ? ($deal->size_id ?? null) : null
                ];
            });


        return ['response' => $mapped];
    }

    public function sliders(Request $request)
    {
        $sliders = Slider::with('item_info', 'category_info')->where('branch_id', $request->branch_id)->where('is_available', 1)->orderByDesc('id')->get();
        return response()->json([
            'status' => true,
            'data' => $sliders->map(function ($slider) {
                return [
                   'image' => helper::image_path($slider->image),
                ];
            })
        ]);
    }
}