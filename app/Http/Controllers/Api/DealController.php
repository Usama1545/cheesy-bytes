<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Item;
use App\Models\user;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\DealItem;
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
use App\Models\DealCategory;
use App\Models\AddonCrust;
use Illuminate\Support\Facades\Hash;

class DealController extends Controller
{
    public function deals(Request $request)
    {
        $user_id = @Auth::user()->id;
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
                $image =
                    $deal->mobile_image ? helper::image_path($deal->mobile_image)
                    : ($deal->web_image ? helper::image_path($deal->web_image)
                    : $product?->item_image?->image_url);

                // Final unified structure
                return [
                    'deal_id'      => $deal->deal_id,
                    'deal_type'    => $deal->deal_type == 2 ? 0 : $deal->deal_type,
                    'title'        => $deal->title ?? $deal->product->item_name,
                    'description'  => $deal->description ?? $deal->product->item_description,
                    'start_date'   => $deal->start_date,
                    'end_date'     => $deal->end_date,
                    'start_time'   => $deal->start_time,
                    'end_time'     => $deal->end_time,
                    'image'        => $image,
                    'dealPrice'    => $deal->dealPrice,

                    'meta' => [
                        'is_flat'      => $deal->deal_type == 1,
                        'is_selective' => $deal->deal_type == 2 || $deal->deal_type == 0,
                        'is_bogo'      => $deal->deal_type == 3,
                        'is_bmsm'      => $deal->deal_type == 4,
                    ],

                    // Selective → Only return size_id
                    'size_id' => $deal->deal_type == 2 ? ($deal->size_id ?? null) : null
                ];
            });


        return ['response' => $mapped];
    }

    public function showDealItem(Request $request, $slug)
    {
        // dd($slug);
        $dealId = $request->deal_id;

        // Basic validation
        if (!$slug || !$dealId) {
            return response()->json(['response' => 'Invalid Request'], 400);
        }

        $branchId = $request->branch_id;
        $userId   = auth('sanctum')->user()->id ?? "";

        // Fetch deal
        $deal = TopDeals::where('id', $dealId)->firstOrFail();

        // Load item
        $item = Item::with(['subcategory_info', 'category_info', 'item_image'])
            ->select(
                'item.*',
                DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId 
                        THEN COALESCE(item_prices.price, 0) 
                        ELSE 0 END) AS item_price"),
                DB::raw("(CASE WHEN favorite.item_id IS NULL THEN 0 ELSE 1 END) AS is_favorite")
            )
            ->leftJoin('favorite', function ($q) use ($userId) {
                $q->on('favorite.item_id', '=', 'item.id')
                ->where('favorite.user_id', '=', $userId);
            })
            ->leftJoin('item_prices', function ($q) use ($branchId) {
                $q->on('item_prices.item_id', '=', 'item.id')
                ->where('item_prices.branch_id', '=', $branchId);
            })
            ->where('item.slug', $slug)
            ->firstOrFail();

        // BASE PRICE
        $price = $item->item_price;

        // ---------------------------------------------------
        //            DEAL-SPECIFIC PRICE CALCULATION
        // ---------------------------------------------------

        if ($deal->deal_type == 2 || $deal->deal_type == 0) {
            // Flat deal
            if ($deal->offer_type == 1) {
                $price = max(0, $price - $deal->offer_amount);
            }
             else {
                $price -= $price * ($deal->offer_amount / 100);
            }

        }elseif ($deal->deal_type == 1) {
            // selective Offer
            $price = $deal->offer_amount ;
        }elseif ($deal->deal_type == 3) {
            // BOGO / Buy One Get One
            $dealItem = DealItem::where('deal_id', $deal->id)
                ->where('item_id', $item->id)
                ->get();

            if ($dealItem->count() > 0) {
                $dealCategory = DealCategory::find($request->deal_category_id);
                if ($dealCategory && $dealCategory->is_free == 1) {
                    if ($deal->offer_type == 1) {
                        $price = max(0, $price - $deal->offer_amount);
                    } else {
                        $price -= ($price * ($deal->offer_amount / 100));
                    }
                }
            }

        } else {
            // Percent or Fixed discount
            if ($deal->offer_type == 1) {
                $price = max(0, $price - $deal->offer_amount);
            }
             else {
                $price -= $price * ($deal->offer_amount / 100);
            }
        }

        // ---------------------------------------------------
        //                ADDONS (Optimized)
        // ---------------------------------------------------
        $addonGroupIds = explode(',', $item->addons_id);

        $addons = Addons::select('id', 'addongroup_id', 'name', 'price')
            ->whereIn('addongroup_id', $addonGroupIds)
            ->where('is_deleted', 2)
            ->where('is_available', 1)
            ->orderBy('reorder_id')
            ->get()
            ->groupBy('addongroup_id');

        $addonGroups = AddonsGroup::select('id', 'name', 'selection_type', 'selection_count', 'min_count', 'max_count')
            ->whereIn('id', $addonGroupIds)
            ->where('is_deleted', 2)
            ->where('is_available', 1)
            ->orderBy('reorder_id')
            ->get()
            ->map(function ($group) use ($addons) {
                $group->addons = ($addons[$group->id] ?? collect())->values();
                return $group;
            });

        // ---------------------------------------------------
        //                    EXTRAS
        // ---------------------------------------------------
        $extras = Extra::where('item_id', $item->id)
            ->where(function ($q) use ($branchId) {
                $q->where('branch_id', 'like', "%,$branchId,%")
                ->orWhere('branch_id', 'like', "$branchId,%")
                ->orWhere('branch_id', 'like', "%,$branchId")
                ->orWhere('branch_id', '=', $branchId);
            })
            ->get();

        // ---------------------------------------------------
        //             FINAL UNIFIED RESPONSE
        // ---------------------------------------------------
        return response()->json([
            'status' => true,
            'data' => [
                "id" => $item->id,
                "slug" => $item->slug,
                "deal_id" => $deal->id,
                "deal_type" => $deal->deal_type == 2 ? 0 : $deal->deal_type,
                "deal_category_id" => $request->deal_category_id ?? null,
                "item_name" => $item->item_name,
                "price" => round($price, 2),
                "tax" => $item->tax,
                "image_name" => optional($item->item_image)->image_name,
                "is_favorite" => $item->is_favorite,
                "addons_group" => $addonGroups,
                "extras" => $extras,
            ]
        ]);
    }

    public function dealItems(Request $request, $dealId)
    {
        \Log::info('deals fetched', [
            'dealId' => $dealId,
            'request' => $request->all(),
        ]);

        $user_id = optional(Auth::user())->id;
        $branchId = $request->branch_id;
        $sessionId = $user_id ?? $request->header('X-Session-Id');

        $deal = TopDeals::with('product')->findOrFail($dealId);

        $dealType = $deal->deal_type == 2 ? 0 : $deal->deal_type;

        /**
         * =========================
         * BOGO DEAL (TYPE 3)
         * =========================
         */
            if ($dealType == 3) {

                $dealCategories = DealCategory::where('deal_id', $dealId)
                    ->with('category')
                    ->where('is_free', false) // 👈 filter here)
                    ->get();

                $response = $dealCategories->map(function ($cat) use ($branchId, $deal) {

                    $dealItems = DealItem::where('deal_category_id', $cat->id)
                        ->with(['item' => function ($q) use ($branchId, $cat) {

                            $q->with(['item_image', 'category_info']);

                            $q->with([
                                'itemPrices' => function ($p) use ($branchId) {
                                    $p->where('branch_id', $branchId);
                                },
                                'pizzaPrices' => function ($p) use ($branchId, $cat) {
                                    $p->where('branch_id', $branchId)
                                    ->where('size_id', $cat->size_id);
                                }
                            ]);
                        }])
                        ->get();

                    $items = $dealItems->map(function ($dealItem) use ($cat, $deal) {

                        $item = $dealItem->item;

                        $isPizza = optional($item->category_info)->slug === 'pizza';

                        $basePrice = $isPizza
                            ? (optional($item->pizzaPrices->first())->price ?? 0)
                            : (optional($item->itemPrices->first())->price ?? 0);

                        if ($cat->is_free) {
                            if ($deal->offer_type == 1) {
                                $price = max(0, $basePrice - $deal->offer_amount);
                            } else {
                                $price = $basePrice - ($basePrice * ($deal->offer_amount / 100));
                            }
                        } else {
                            $price = $basePrice;
                        }

                        return [
                            'id'        => $item->id,
                            'name'      => $item->item_name,
                            'slug'      => $item->slug,
                            'image_url' => optional($item->item_image)->image_url,
                            'price'     => number_format(floor($price * 100) / 100, 2, '.', ''),
                        ];
                    });

                    return [
                        'deal_category_id' => $cat->id,
                        'size_id'          => $cat->size_id,
                        'category_id'      => $cat->category_id,
                        'category_name'    => optional($cat->category)->category_name,
                        'is_free'          => (bool) $cat->is_free,
                        'min'              => $cat->quantity,
                        'items'            => $items,
                    ];
                });

                return response()->json([
                    'deal_id'    => $dealId,
                    'deal_type'  => 3,
                    'categories' => $response
                ]);
            }

        /**
         * =========================
         * OTHER DEALS (1,2,4)
         * =========================
         */

        $productIds = explode(',', $deal->product_ids);

        $items = Item::whereIn('id', $productIds)
            ->with([
                'item_image',
                'itemPrices' => function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                }
            ])
            ->get()
            ->filter(function ($item) {
                return $item->itemPrices->first();
            })
            ->map(function ($item) use ($deal) {

                $price = $item->itemPrices->first()->price;

                if ($deal->deal_type == 2 || $deal->deal_type == 0) {
                    if ($deal->offer_type == 1) {
                        $price = max(0, $price - $deal->offer_amount);
                    } else {
                        $price -= $price * ($deal->offer_amount / 100);
                    }
                } elseif ($deal->deal_type == 1) {
                    $price = $deal->offer_amount;
                }

                return [
                    'id'        => $item->id,
                    'name'      => $item->item_name,
                    'slug'      => $item->slug,
                    'image_url' => optional($item->item_image)->image_url,
                    'price'     => number_format($price, 2, '.', '')
                ];
            })->values();

        /**
         * TYPE 2 → return flat items (app expects this)
         */
        if ($dealType == 2) {
            return response()->json([
                'deal_id'   => $dealId,
                'deal_type' => 2,
                'items'     => $items
            ]);
        }

        /**
         * TYPE 1 & 4 → wrap in dummy category
         */
        return response()->json([
            'deal_id'   => $dealId,
            'deal_type' => $dealType,
            'categories' => [
                [
                    'deal_category_id' => null,
                    'size_id'          => null,
                    'category_id'      => null,
                    'category_name'    => $deal->name ?? 'Select Items',
                    'is_free'          => false,
                    'min'              => 1,
                    'items'            => $items
                ]
            ]
        ]);
    }
}