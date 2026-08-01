<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\DealItem;
use App\Models\itemPrice;
use App\Models\PizzaPrice;
use App\Models\ProductSizeCrust;
use App\Models\TopDeals;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Addons;
use App\Helpers\helper;
use App\Models\AddonsGroup;
use App\Models\Extra;
use App\Models\Ratting;
use App\Models\SystemAddons;
use App\Models\DealCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ItemController extends Controller
{
    public function showitem(Request $request)
    {
        $topdeals = helper::top_deals();
        $user_id = @Auth::user()->id;
        $branchId = Session::get('branch_id');
        $iteminfo = Item::with(['subcategory_info', 'category_info', 'item_image'])
            ->select('item.*',
                DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),
                DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"))
            ->leftJoin('favorite', function ($query) use ($user_id) {
                $query->on('favorite.item_id', '=', 'item.id')
                    ->where('favorite.user_id', '=', $user_id);
            })
            ->leftJoin('item_prices', function ($query) use ($branchId) {
                $query->on('item_prices.item_id', '=', 'item.id')
                    ->where('item_prices.branch_id', '=', $branchId);
            })
            ->where('item.slug', '=', $request->slug)
            ->where('item.item_status', '1')
            ->first();
            if(isset($request->deal_id))
        {
            $product_id = TopDeals::where('id', $request->deal_id)->first()->product_id;
            $price = ItemPrice::where('item_id', $product_id)->where('branch_id',$branchId)->pluck('price')->first();
        }
        $itemdata = array(
            "id" => $iteminfo->id,
            "slug" => $iteminfo->slug,
            "item_name" => $iteminfo->item_name,
            "item_type" => $iteminfo->item_type,
            "item_type_image" => $iteminfo->item_type == 1 ? helper::image_path("veg.svg") : helper::image_path("nonveg.svg"),
            "price" => $price ?? $iteminfo->item_price ?? $iteminfo->prices,
            "video_url" => $iteminfo->video_url,
            "is_top_deals" => $iteminfo->is_top_deals,
            "deal_id" => null,
            "tax" => $iteminfo->tax,
            "image_name" => @$iteminfo['item_image']->image_name,
            "is_favorite" => $iteminfo->is_favorite,
            "addons_group" => AddonsGroup::select('id', 'name', 'selection_type', 'selection_count', 'min_count', 'max_count')->whereIn('id', explode(',', $iteminfo->addons_id))->where('is_deleted', 2)->where('is_available', 1)->orderBy('reorder_id')->get(),
            "addons" => Addons::select('id', 'addongroup_id', 'name', 'price')->where('is_deleted', 2)->where('is_available', 1)->orderBy('reorder_id')->get(),
            "extras" => Extra::where('item_id', $iteminfo->id)->where(function ($query) {
                    $branchId = Session::get('branch_id');
                    $query->where('branch_id', 'like', "%,$branchId,%") // Match middle
                    ->orWhere('branch_id', 'like', "$branchId,%") // Match start
                    ->orWhere('branch_id', 'like', "%,$branchId") // Match end
                    ->orWhere('branch_id', '=', $branchId);
                })->get(),
        );
        foreach ($itemdata['addons_group'] as $addons_group) {
            $addons_group->availableAddons = $itemdata['addons']->where('addongroup_id', $addons_group->id);
        }
        if ($request->ajax()) {
            $html = view('web.addonsmodal', compact('topdeals', 'itemdata'))->render();
            return response()->json(['status' => 1, 'output' => $html, 'id' => $iteminfo->id], 200);
        }
    }

    public function showDealitem(Request $request)
    {
        $branchId = Session::get('branch_id');
        $topdeals = helper::top_deals();
        $user_id = @Auth::user()->id;
        $iteminfo = Item::with(['subcategory_info', 'category_info', 'item_image'])
            ->select('item.*',
                DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"),
                DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'))
            ->leftJoin('favorite', function ($query) use ($user_id) {
                $query->on('favorite.item_id', '=', 'item.id')
                    ->where('favorite.user_id', '=', $user_id);
            })->leftJoin('item_prices', function ($query) use ($branchId) {
                $query->on('item_prices.item_id', '=', 'item.id')
                    ->where('item_prices.branch_id', '=', $branchId);
            })
            ->where('item.slug', '=', $request->slug)
            ->first();
        $deal = TopDeals::where('slug', $request->deal_id)->first();

        if (isset($deal->deal_type) && $deal->deal_type == 1) {

            $price = $deal->offer_amount;

        }  elseif (isset($deal->deal_type) && $deal->deal_type == 3) {
            $price = $iteminfo->item_price;
        }else {
            if ($deal->offer_type == 1) {

                if ($iteminfo->item_price > $deal->offer_amount) {
                    $price = $iteminfo->item_price - $deal->offer_amount;
                } else {
                    $price = $iteminfo->item_price;
                }
            } else {
                $price = $iteminfo->item_price - $iteminfo->item_price * ($deal->offer_amount / 100);
            }
        }

        if(isset($request->deal_id))
        {
            $deal_id = $request->deal_id;
        }
        else{
            $deal_id = null;
        }
        $itemdata = array(
            "id" => $iteminfo->id,
            "slug" => $iteminfo->slug,
            "deal_id" => $deal_id,
            "item_name" => $iteminfo->item_name,
            "item_type" => $iteminfo->item_type,
            "item_type_image" => $iteminfo->item_type == 1 ? helper::image_path("veg.svg") : helper::image_path("nonveg.svg"),
            "price" => $price,
            "video_url" => $iteminfo->video_url,
            "is_top_deals" => $iteminfo->is_top_deals,
            "tax" => $iteminfo->tax,
            "image_name" => @$iteminfo['item_image']->image_name,
            "is_favorite" => $iteminfo->is_favorite,
            "addons_group" => AddonsGroup::select('id', 'name', 'selection_type', 'selection_count', 'min_count', 'max_count')
                ->whereIn('id', explode(',', $iteminfo->addons_id))
                ->where('is_deleted', 2)
                ->where('is_available', 1)
                ->orderBy('reorder_id')
                ->with([
                    'availableAddons' => function ($query) use ($deal) { // Pass $deal->size_id
                        $query->select('id', 'addongroup_id', 'name', 'price', 'product_id')
                            ->where('is_deleted', 2)
                            ->where('is_available', 1)
                            ->orderByDesc('id')
                            ->with(['crusts' => function ($query) use ($deal) {
                                $query->whereHas('crust') // Ensure it has a related crust
                                ->where('size_id', $deal->size_id) // Match the provided size_id
                                ->with('crust:id,name'); // Fetch crust name
                            }]);
                    }
                ])
                ->get(),
            "extras" => Extra::where('item_id', $iteminfo->id)
                ->where(function ($query) {
                    $branchId = Session::get('branch_id');
                    $query->where('branch_id', 'like', "%,$branchId,%") // Match middle
                    ->orWhere('branch_id', 'like', "$branchId,%") // Match start
                    ->orWhere('branch_id', 'like', "%,$branchId") // Match end
                    ->orWhere('branch_id', '=', $branchId);
                })
                ->get(),
        );

        if ($request->ajax()) {
            $html = view('web.dealAddonsModal', compact('topdeals', 'itemdata'))->render();
            return response()->json(['status' => 1, 'output' => $html, 'id' => $iteminfo->id], 200);
        }
    }
    public function showBogoDealitem(Request $request)
    {
        $branchId = Session::get('branch_id');
        $topdeals = helper::top_deals();
        $user_id = optional(Auth::user())->id;

        $iteminfo = Item::with(['subcategory_info', 'category_info', 'item_image'])
            ->select('item.*',
                DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"),
                DB::raw('(CASE WHEN favorite.item_id IS NULL THEN 0 ELSE 1 END) AS is_favorite'))
            ->leftJoin('favorite', function ($query) use ($user_id) {
                $query->on('favorite.item_id', '=', 'item.id')
                    ->where('favorite.user_id', '=', $user_id);
            })
            ->leftJoin('item_prices', function ($query) use ($branchId) {
                $query->on('item_prices.item_id', '=', 'item.id')
                    ->where('item_prices.branch_id', '=', $branchId);
            })
            ->where('item.slug', '=', $request->slug)
            ->firstOrFail();

        $deal = TopDeals::findOrFail($request->deal_id);
        $price = $iteminfo->item_price;
        if ($deal->deal_type == 3) {
            $dealItem = DealItem::where('deal_id', $deal->id)
                ->where('item_id', $iteminfo->id)
                ->first();

            if ($dealItem) {
                $dealCategory = \App\Models\DealCategory::where('id', $request->deal_category_id)
                    ->first();

                if ($dealCategory && $dealCategory->is_free == 1) {
                    if ($deal->offer_type == 1) {
                        $price = max(0, $price - $deal->offer_amount);
                    } else {
                        $price = $price - ($price * ($deal->offer_amount / 100));
                    }
                }
            }
        }

        $deal_id = $request->deal_id ?? null;

        $itemdata = [
            "id" => $iteminfo->id,
            "slug" => $iteminfo->slug,
            "deal_id" => $deal_id,
            "deal_category_id" => $request->deal_category_id,
            "item_name" => $iteminfo->item_name,
            "item_type" => $iteminfo->item_type,
            "item_type_image" => $iteminfo->item_type == 1 ? helper::image_path("veg.svg") : helper::image_path("nonveg.svg"),
            "price" => $price,
            "video_url" => $iteminfo->video_url,
            "is_top_deals" => $iteminfo->is_top_deals,
            "tax" => $iteminfo->tax,
            "image_name" => optional($iteminfo->item_image)->image_name,
            "is_favorite" => $iteminfo->is_favorite,
            "addons_group" => AddonsGroup::select('id', 'name', 'selection_type', 'selection_count', 'min_count', 'max_count')
                ->whereIn('id', explode(',', $iteminfo->addons_id))
                ->where('is_deleted', 2)
                ->where('is_available', 1)
                ->orderBy('reorder_id')
                ->with([
                    'availableAddons' => function ($query) use ($deal) {
                        $query->select('id', 'addongroup_id', 'name', 'price', 'product_id')
                            ->where('is_deleted', 2)
                            ->where('is_available', 1)
                            ->orderByDesc('id')
                            ->with(['crusts' => function ($query) use ($deal) {
                                $query->whereHas('crust')
                                    ->where('size_id', $deal->size_id)
                                    ->with('crust:id,name');
                            }]);
                    }
                ])
                ->get(),
            "extras" => Extra::where('item_id', $iteminfo->id)
                ->where(function ($query) use ($branchId) {
                    $query->where('branch_id', 'like', "%,$branchId,%")
                        ->orWhere('branch_id', 'like', "$branchId,%")
                        ->orWhere('branch_id', 'like', "%,$branchId")
                        ->orWhere('branch_id', '=', $branchId);
                })
                ->get(),
        ];

        if ($request->ajax()) {
            $html = view('web.dealAddonsModal', compact('topdeals', 'itemdata'))->render();
            return response()->json(['status' => 1, 'output' => $html, 'id' => $iteminfo->id], 200);
        }
    }


    public function productdetails($id, Request $request)
    {
        $branchId = Session::get('branch_id');
        $dealprice = null;

        // Fetch item with price and relations
        $getitemdata = Item::with('category_info', 'subcategory_info', 'item_images', 'pizzaPrices', 'item_image')
            ->select('item.*', DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"))
            ->leftJoin('item_prices', function ($query) use ($branchId) {
                $query->on('item_prices.item_id', '=', 'item.id')
                    ->where('item_prices.branch_id', $branchId);
            })
            ->groupBy('item.id')
            ->where('item.id', $id)
            ->where('item.item_status', '1')
            ->first();

        if (!$getitemdata) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        // Fetch addons group
        $addonsIds = explode(',', $getitemdata->addons_id);
        $getitemdata['addons_group'] = AddonsGroup::select('id', 'name', 'selection_type', 'selection_count', 'min_count', 'max_count')
            ->whereIn('id', $addonsIds)
            ->where('is_deleted', 2)
            ->where('is_available', 1)
            ->orderBy('reorder_id')
            ->get();

        // Fetch addons filtered by branch
        $getitemdata['addons'] = Addons::select('id', 'addongroup_id', 'name', 'price')
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

        // Filter addons_group to only include groups with available addons
        $getitemdata['addons_group'] = $getitemdata['addons_group']->filter(function ($group) use ($getitemdata) {
            $group->availableAddons = $getitemdata['addons']->where('addongroup_id', $group->id);
            return $group->availableAddons->isNotEmpty();
        })->values();

        // Fetch extras filtered by branch
        $getitemdata['extras'] = Extra::where('item_id', $getitemdata->id)
            ->where(function ($query) use ($branchId) {
                $query->where('branch_id', 'like', "%,$branchId,%")
                    ->orWhere('branch_id', 'like', "$branchId,%")
                    ->orWhere('branch_id', 'like', "%,$branchId")
                    ->orWhere('branch_id', '=', $branchId);
            })
            ->get();

        $deal_type = null;
        $topDeal = null;

        if (isset($request['dealId']) && isset($request['sizeId'])) {
            $topDeal = TopDeals::find($request['dealId']);
            if (!$topDeal) {
                return response()->json(['error' => 'Invalid deal ID'], 400);
            }

            $deal_type = $topDeal->deal_type;
            $sizeIds = explode(',', $request['sizeId']);

            if ($deal_type == 3) {
                $deal_category = DealCategory::find($request['dealCategoryId'] ?? 0);

                // Base price from pizzaPrices if exists
                if (!$getitemdata->pizzaPrices->isEmpty()) {
                    $dealPrice = $getitemdata->pizzaPrices
                        ->filter(fn($price) => in_array($price->size_id, $sizeIds) && $price->branch_id == $branchId)
                        ->sortBy('price')
                        ->first();

                    $basePrice = $dealPrice ? $dealPrice->price : $getitemdata->item_price;
                } else {
                    $basePrice = $getitemdata->item_price;
                }

                // Apply deal logic
                if (!$deal_category || !$deal_category->is_free) {
                    $dealprice = $basePrice;
                } else {
                    if ($topDeal->offer_type == 1) { // Fixed discount
                        $dealprice = max(0, $basePrice - $topDeal->offer_amount);
                    } elseif ($topDeal->offer_type == 2) { // Percentage discount
                        $dealprice = $basePrice - ($basePrice * ($topDeal->offer_amount / 100));
                    } else {
                        $dealprice = $basePrice;
                    }
                }
            } else {
                // Deal type 1 or others: fetch pizza price first
                $dealprice = PizzaPrice::where('item_id', $topDeal->product_id)
                    ->where('branch_id', $branchId)
                    ->whereIn('size_id', $sizeIds)
                    ->orderBy('price', 'asc')
                    ->value('price');

                if (!$dealprice) {
                    $dealprice = ItemPrice::where('item_id', $topDeal->product_id)
                        ->where('branch_id', $branchId)
                        ->value('price');
                }
            }

            // Fetch crusts filtered by sizeIds
            $crusts = ProductSizeCrust::where('item_id', $id)
                ->when($sizeIds, fn($q) => $q->whereIn('size_id', $sizeIds))
                ->get();
        } else {
            $crusts = ProductSizeCrust::where('item_id', $id)->get();
        }

        $prices = PizzaPrice::where('item_id', $id)->where('branch_id', $branchId)->get();

        // Group crusts by size
        $groupedData = $crusts->groupBy('size_id')->map(function ($items) use ($prices, $dealprice, $deal_type, $topDeal) {
            $firstItem = $items->first();
            $sizePrice = $prices->firstWhere('size_id', $firstItem->size_id);
            $sizePriceValue = $sizePrice->price ?? 0;

            $sizeDealPrice = null;
            if ($deal_type == 2 || $deal_type == 0 && $topDeal) {
                if ($topDeal->offer_type == 1) {
                    $sizeDealPrice = max(0, $sizePriceValue - $topDeal->offer_amount);
                } elseif ($topDeal->offer_type == 2) {
                    $sizeDealPrice = $sizePriceValue - ($sizePriceValue * ($topDeal->offer_amount / 100));
                } else {
                    $sizeDealPrice = $sizePriceValue;
                }
            }

            return [
                'id' => $firstItem->size_id,
                'name' => $firstItem->size->name ?? null,
                'label' => $firstItem->size->label ?? null,
                'size_price' => $sizeDealPrice ?? $dealprice ?? $sizePriceValue,
                'crusts' => $items->map(fn($item) => [
                    'id' => $item->crust_id,
                    'name' => $item->crust->name ?? null,
                    'price' => $item->price,
                ])->toArray(),
            ];
        })->values()->toArray();

        $responce = [
            'item_detail' => $getitemdata,
            'crust_data' => $groupedData
        ];

        return ['responce' => $responce];
    }


    public function itemdetails(Request $request)
    {
        $user_id = @Auth::user()->id;
        $session_id = Session::getId();
        $topdeals = helper::top_deals();
        $branchId = Session::get('branch_id');
        $isPizza = false;

        if ($user_id != null) {
            $getitemdata = Item::with('category_info', 'subcategory_info', 'item_images', 'item_image')->select('item.*',
                DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),
                DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"),
                DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                ->leftJoin('favorite', function ($query) use ($user_id) {
                    $query->on('favorite.item_id', '=', 'item.id')
                        ->where('favorite.user_id', '=', $user_id);
                })->leftJoin('item_prices', function ($query) use ($branchId) {
                    $query->on('item_prices.item_id', '=', 'item.id')
                        ->where('item_prices.branch_id', '=', $branchId);
                })
                ->leftJoin('cart', function ($query) use ($user_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.user_id', '=', $user_id)
                        ->where('cart.buynow', '=', '0');
                })
                ->groupBy('item.id', 'cart.item_id')
                ->where('item.slug', '=', $request->slug)
                ->first();
            $getitemdata['addons_group'] = AddonsGroup::select('id', 'name', 'selection_type', 'selection_count', 'min_count', 'max_count')->whereIn('id', explode(',', $getitemdata->addons_id))->where('is_deleted', 2)->where('is_available', 1)->orderByDesc('id')->get();
            $getitemdata['addons'] = Addons::select('id', 'addongroup_id', 'name', 'price')
                ->where('is_deleted', 2)
                ->where('is_available', 1)
                ->where(function ($query) {
                    $branchId = \Illuminate\Support\Facades\Session::get('branch_id');
                    $query->where('branch_ids', 'like', "%,$branchId,%") // Match middle
                    ->orWhere('branch_ids', 'like', "$branchId,%") // Match start
                    ->orWhere('branch_ids', 'like', "%,$branchId") // Match end
                    ->orWhere('branch_ids', '=', $branchId);
                })
                ->orderBy('reorder_id')->get();
            foreach ($getitemdata['addons_group'] as $addons_group) {
                $addons_group->availableAddons = $getitemdata['addons']->where('addongroup_id', $addons_group->id);
            }
            $getitemdata['extras'] = Extra::where('item_id', $getitemdata->id)->where(function ($query) {
                    $branchId = Session::get('branch_id');
                    $query->where('branch_id', 'like', "%,$branchId,%") // Match middle
                    ->orWhere('branch_id', 'like', "$branchId,%") // Match start
                    ->orWhere('branch_id', 'like', "%,$branchId") // Match end
                    ->orWhere('branch_id', '=', $branchId);
                })->get();
            $getrelateditems = Item::with('category_info', 'subcategory_info', 'item_image')->select('item.*', DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'), DB::raw('(case when item.price is null then 0 else item.price end) as item_price'), DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                ->leftJoin('favorite', function ($query) use ($user_id) {
                    $query->on('favorite.item_id', '=', 'item.id')
                        ->where('favorite.user_id', '=', $user_id);
                })
                ->leftJoin('cart', function ($query) use ($user_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.user_id', '=', $user_id)
                        ->where('cart.buynow', '=', '0');
                })
                ->groupBy('item.id', 'cart.item_id')
                ->orderByDesc('item.id')
                ->where('item.id', '!=', @$getitemdata->id)
                ->where('item.cat_id', '=', @$getitemdata->cat_id)
                ->where('item.item_status', '1')
                ->take(3)->get();
        } else {
            $getitemdata = Item::with('category_info', 'subcategory_info', 'item_images')
                ->select('item.*',
                    DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"),
                    DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                ->leftJoin('cart', function ($query) use ($session_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.session_id', '=', $session_id)
                        ->where('cart.buynow', '=', '0');
                })->leftJoin('item_prices', function ($query) use ($branchId) {
                    $query->on('item_prices.item_id', '=', 'item.id')
                        ->where('item_prices.branch_id', '=', $branchId);
                })
                ->groupBy('item.id', 'cart.item_id')
                ->where('item.slug', '=', $request->slug)
                ->first();
            $getitemdata['addons_group'] = AddonsGroup::select('id', 'name', 'selection_type', 'selection_count', 'min_count', 'max_count')->whereIn('id', explode(',', $getitemdata->addons_id))->where('is_deleted', 2)->where('is_available', 1)->orderByDesc('id')->get();
            $getitemdata['addons'] = Addons::select('id', 'addongroup_id', 'branch_ids', 'name', 'price')
                ->where(function ($query) {
                    $branchId = Session::get('branch_id');
                    $query->where('branch_ids', 'like', "%,$branchId,%") // Match middle
                    ->orWhere('branch_ids', 'like', "$branchId,%") // Match start
                    ->orWhere('branch_ids', 'like', "%,$branchId") // Match end
                    ->orWhere('branch_ids', '=', $branchId);
                })
                ->where('is_deleted', 2)->where('is_available', 1)->orderBy('reorder_id')->get();
            foreach ($getitemdata['addons_group'] as $addons_group) {
                $addons_group->availableAddons = $getitemdata['addons']->where('addongroup_id', $addons_group->id);
            }
            $getrelateditems = Item::with('category_info', 'subcategory_info', 'item_image')->select('item.*', DB::raw('(case when item.price is null then 0 else item.price end) as item_price'), DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                ->leftJoin('cart', function ($query) use ($session_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.session_id', '=', $session_id)
                        ->where('cart.buynow', '=', '0');
                })
                ->groupBy('item.id', 'cart.item_id')
                ->orderByDesc('item.id')
                ->where('item.id', '!=', @$getitemdata->id)
                ->where('item.cat_id', '=', @$getitemdata->cat_id)
                ->where('item.item_status', '1')
                ->take(3)->get();
        }
        $crusts = ProductSizeCrust::where('item_id', $getitemdata->id)->get();
        $prices = PizzaPrice::where('item_id', $getitemdata->id)->where('branch_id', $branchId)->get();
        $crustSizes = $crusts->groupBy('size_id')->map(function ($items) use ($prices) {
            $firstItem = $items->first();
            $sizePrice = $prices->firstWhere('size_id', $firstItem->size_id);
            $sizePriceValue = $sizePrice->price ?? 0;

            $sizeDealPrice = $sizePriceValue;
            
            return [
                'id' => $firstItem->size_id,
                'name' => $firstItem->size->name ?? null,
                'label' => $firstItem->size->label ?? null,
                'size_price' => $sizeDealPrice ?? $sizePriceValue,
                'crusts' => $items->map(fn($item) => [
                    'id' => $item->crust_id,
                    'name' => $item->crust->name ?? null,
                    'price' => $item->price,
                ])->toArray(),
            ];
        })->values()->toArray();
        if ($getitemdata && $getitemdata->category_info && $getitemdata->category_info->slug == 'pizza') {
            $isPizza = true;
        }

        $itemreviewdata = Ratting::with('user_info')->select('id', 'ratting', 'comment', 'item_id', 'user_id', 'created_at')->where('item_id', $getitemdata->id)->where('status', 1)->get();
        $fivestaraverage = Ratting::where('item_id', $getitemdata->id)->where('status', 1)->where('ratting', 5)->count();
        $fourstaraverage = Ratting::where('item_id', $getitemdata->id)->where('status', 1)->where('ratting', 4)->count();
        $threestaraverage = Ratting::where('item_id', $getitemdata->id)->where('status', 1)->where('ratting', 3)->count();
        $twostaraverage = Ratting::where('item_id', $getitemdata->id)->where('status', 1)->where('ratting', 2)->count();
        $onestaraverage = Ratting::where('item_id', $getitemdata->id)->where('status', 1)->where('ratting', 1)->count();
        $data['fivestaraverage'] = $fivestaraverage;
        $data['fourstaraverage'] = $fourstaraverage;
        $data['threestaraverage'] = $threestaraverage;
        $data['twostaraverage'] = $twostaraverage;
        $data['onestaraverage'] = $onestaraverage;
        return view('web.productdetails', $data, compact('topdeals', 'getitemdata', 'getrelateditems', 'itemreviewdata', 'crustSizes', 'isPizza'));
    }

    public function itemdetailsCon(Request $request, $county)
    {
        $user_id = @Auth::user()->id;
        $session_id = Session::getId();
        $topdeals = helper::top_deals();

        if ($user_id != null) {
            $getitemdata = Item::with('category_info', 'subcategory_info', 'item_images', 'item_image')->select('item.*', DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'), DB::raw('(case when item.price is null then 0 else item.price end) as item_price'), DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                ->leftJoin('favorite', function ($query) use ($user_id) {
                    $query->on('favorite.item_id', '=', 'item.id')
                        ->where('favorite.user_id', '=', $user_id);
                })
                ->leftJoin('cart', function ($query) use ($user_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.user_id', '=', $user_id)
                        ->where('cart.buynow', '=', '0');
                })
                ->groupBy('item.id', 'cart.item_id')
                ->where('item.slug', '=', $request->slug)
                ->first();
            $getitemdata['addons_group'] = AddonsGroup::select('id', 'name', 'selection_type', 'selection_count', 'min_count', 'max_count')->whereIn('id', explode(',', $getitemdata->addons_id))->where('is_deleted', 2)->where('is_available', 1)->orderByDesc('id')->get();
            $getitemdata['addons'] = Addons::select('id', 'addongroup_id', 'name', 'price')->where('is_deleted', 2)->where('is_available', 1)->orderByDesc('id')->get();
            foreach ($getitemdata['addons_group'] as $addons_group) {
                $addons_group->availableAddons = $getitemdata['addons']->where('addongroup_id', $addons_group->id);
            }
            $getitemdata['extras'] = Extra::where('item_id', $getitemdata->id)->where(function ($query) {
                    $branchId = Session::get('branch_id');
                    $query->where('branch_id', 'like', "%,$branchId,%") // Match middle
                    ->orWhere('branch_id', 'like', "$branchId,%") // Match start
                    ->orWhere('branch_id', 'like', "%,$branchId") // Match end
                    ->orWhere('branch_id', '=', $branchId);
                })->get();
            $getrelateditems = Item::with('category_info', 'subcategory_info', 'item_image')->select('item.*', DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'), DB::raw('(case when item.price is null then 0 else item.price end) as item_price'), DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                ->leftJoin('favorite', function ($query) use ($user_id) {
                    $query->on('favorite.item_id', '=', 'item.id')
                        ->where('favorite.user_id', '=', $user_id);
                })
                ->leftJoin('cart', function ($query) use ($user_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.user_id', '=', $user_id)
                        ->where('cart.buynow', '=', '0');
                })
                ->groupBy('item.id', 'cart.item_id')
                ->orderByDesc('item.id')
                ->where('item.id', '!=', @$getitemdata->id)
                ->where('item.cat_id', '=', @$getitemdata->cat_id)
                ->where('item.item_status', '1')
                ->take(3)->get();
        } else {
            $getitemdata = Item::with('category_info', 'subcategory_info', 'item_images')->select('item.*', DB::raw('(case when item.price is null then 0 else item.price end) as item_price'), DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                ->leftJoin('cart', function ($query) use ($session_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.session_id', '=', $session_id)
                        ->where('cart.buynow', '=', '0');
                })
                ->groupBy('item.id', 'cart.item_id')
                ->where('item.slug', '=', $request->slug)
                ->where('item.item_status', '1')
                ->first();
            $getitemdata['addons_group'] = AddonsGroup::select('id', 'name', 'selection_type', 'selection_count', 'min_count', 'max_count')->whereIn('id', explode(',', $getitemdata->addons_id))->where('is_deleted', 2)->where('is_available', 1)->orderByDesc('id')->get();
            $getitemdata['addons'] = Addons::select('id', 'addongroup_id', 'name', 'price')->where('is_deleted', 2)->where('is_available', 1)->orderByDesc('id')->get();
            foreach ($getitemdata['addons_group'] as $addons_group) {
                $addons_group->availableAddons = $getitemdata['addons']->where('addongroup_id', $addons_group->id);
            }
            $getrelateditems = Item::with('category_info', 'subcategory_info', 'item_image')->select('item.*', DB::raw('(case when item.price is null then 0 else item.price end) as item_price'), DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                ->leftJoin('cart', function ($query) use ($session_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.session_id', '=', $session_id)
                        ->where('cart.buynow', '=', '0');
                })
                ->groupBy('item.id', 'cart.item_id')
                ->orderByDesc('item.id')
                ->where('item.id', '!=', @$getitemdata->id)
                ->where('item.cat_id', '=', @$getitemdata->cat_id)
                ->take(3)->get();
        }
        $itemreviewdata = Ratting::with('user_info')->select('id', 'ratting', 'comment', 'item_id', 'user_id', 'created_at')->where('item_id', $getitemdata->id)->where('status', 1)->get();
        $fivestaraverage = Ratting::where('item_id', $getitemdata->id)->where('status', 1)->where('ratting', 5)->count();
        $fourstaraverage = Ratting::where('item_id', $getitemdata->id)->where('status', 1)->where('ratting', 4)->count();
        $threestaraverage = Ratting::where('item_id', $getitemdata->id)->where('status', 1)->where('ratting', 3)->count();
        $twostaraverage = Ratting::where('item_id', $getitemdata->id)->where('status', 1)->where('ratting', 2)->count();
        $onestaraverage = Ratting::where('item_id', $getitemdata->id)->where('status', 1)->where('ratting', 1)->count();
        $data['fivestaraverage'] = $fivestaraverage;
        $data['fourstaraverage'] = $fourstaraverage;
        $data['threestaraverage'] = $threestaraverage;
        $data['twostaraverage'] = $twostaraverage;
        $data['onestaraverage'] = $onestaraverage;
        return view('web.productdetails', $data, compact('topdeals', 'getitemdata', 'getrelateditems', 'itemreviewdata', 'county'));
    }

    public function search(Request $request)
    {
        $user_id = @Auth::user()->id;
        $session_id = Session::getId();
        $topdeals = helper::top_deals();
        $branchId = Session::get('branch_id');

        if ($user_id != null) {
            $getsearchitems = array();
            if ($request->has('itemname') && $request->itemname != "") {
                $getsearchitems = Item::with('category_info', 'subcategory_info', 'item_image')
                    ->select('item.*',
                        DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),
                        DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"),
                        DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                    ->leftJoin('item_prices', function ($query) use ($branchId) {
                        $query->on('item_prices.item_id', '=', 'item.id')
                            ->where('item_prices.branch_id', '=', $branchId);
                    })
                    ->leftJoin('order_details', 'order_details.item_id', 'item.id')
                    ->leftJoin('favorite', function ($query) use ($user_id) {
                        $query->on('favorite.item_id', '=', 'item.id')
                            ->where('favorite.user_id', '=', $user_id);
                    })
                    ->leftJoin('cart', function ($query) use ($user_id) {
                        $query->on('cart.item_id', '=', 'item.id')
                            ->where('cart.user_id', '=', $user_id)
                            ->where('cart.buynow', '=', '0');
                    })->where(function ($query) {
                        $branchId = \Illuminate\Support\Facades\Session::get('branch_id');
                        $query->where('branch_ids', 'like', "%,$branchId,%") // Match middle
                        ->orWhere('branch_ids', 'like', "$branchId,%") // Match start
                        ->orWhere('branch_ids', 'like', "%,$branchId") // Match end
                        ->orWhere('branch_ids', '=', $branchId);
                    })
                    ->groupBy('order_details.item_id', 'item.id', 'cart.item_id')
                    ->where('item.item_name', 'like', '%' . $request->itemname . '%')
                    ->where('item.item_status', '1')
                    ->orderByDesc('item.id')->paginate(16);
            }
        } else {
            $getsearchitems = array();
            if ($request->has('itemname') && $request->itemname != "") {
                $getsearchitems = Item::with('category_info', 'subcategory_info', 'item_image')
                    ->select('item.*',
                        DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"),
                        DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                    ->leftJoin('item_prices', function ($query) use ($branchId) {
                        $query->on('item_prices.item_id', '=', 'item.id')
                            ->where('item_prices.branch_id', '=', $branchId);
                    })
                    ->leftJoin('order_details', 'order_details.item_id', 'item.id')
                    ->leftJoin('cart', function ($query) use ($session_id) {
                        $query->on('cart.item_id', '=', 'item.id')
                            ->where('cart.session_id', '=', $session_id)
                            ->where('cart.buynow', '=', '0');
                    })->where(function ($query) {
                        $branchId = \Illuminate\Support\Facades\Session::get('branch_id');
                        $query->where('branch_ids', 'like', "%,$branchId,%") // Match middle
                        ->orWhere('branch_ids', 'like', "$branchId,%") // Match start
                        ->orWhere('branch_ids', 'like', "%,$branchId") // Match end
                        ->orWhere('branch_ids', '=', $branchId);
                    })
                    ->groupBy('order_details.item_id', 'item.id', 'cart.item_id')
                    ->where('item.item_name', 'like', '%' . $request->itemname . '%')
                    ->where('item.item_status', '1')
                    ->orderByDesc('item.id')->paginate(16);
            }
        }

        return view('web.search', compact('topdeals', 'getsearchitems'));
    }

    public function viewall(Request $request)
    {
        $user_id = @Auth::user()->id;
        $session_id = Session::getId();
        $branchId = Session::get('branch_id');
        $getsearchitems = array();
        $topdeals = helper::top_deals();
        $offer_price = 0;
        if ($topdeals != null && $topdeals->offer_type == 1) {
            $offer_price = (int)$topdeals->offer_amount;
        }

        if ($user_id != null) {
            if ($request->has('type') && $request->type != "" && in_array($request->type, array('todayspecial', 'topitems', 'recommended', 'topdeals'))) {
                $getsearchitems = Item::with('category_info', 'subcategory_info', 'item_image')
                    ->select('item.*',
                        DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),
                        DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"),
                        DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'),
                        DB::raw('count(order_details.item_id) as item_order_counter'))
                    ->leftJoin('item_prices', function ($query) use ($branchId) {
                        $query->on('item_prices.item_id', '=', 'item.id')
                            ->where('item_prices.branch_id', '=', $branchId);
                    })
                    ->leftJoin('order_details', 'order_details.item_id', 'item.id')
                    ->leftJoin('favorite', function ($query) use ($user_id) {
                        $query->on('favorite.item_id', '=', 'item.id')
                            ->where('favorite.user_id', '=', $user_id);
                    })
                    ->leftJoin('cart', function ($query) use ($user_id) {
                        $query->on('cart.item_id', '=', 'item.id')
                            ->where('cart.user_id', '=', $user_id)
                            ->where('cart.buynow', '=', '0');
                    })
                    ->where(function ($query) {
                        $branchId = \Illuminate\Support\Facades\Session::get('branch_id');
                        $query->where('branch_ids', 'like', "%,$branchId,%") // Match middle
                        ->orWhere('branch_ids', 'like', "$branchId,%") // Match start
                        ->orWhere('branch_ids', 'like', "%,$branchId") // Match end
                        ->orWhere('branch_ids', '=', $branchId);
                    })
                    ->groupBy('item.id', 'cart.item_id')->where('item.item_status', '1');
                if ($request->has('type') && $request->type != "") {
                    if ($request->type == "todayspecial") {
                        $getsearchitems = $getsearchitems->where('item.is_featured', '1')->orderBy('item.reorder_id');
                    }
                    if ($request->type == "topitems") {
                        $getsearchitems = $getsearchitems->orderByDesc('item_order_counter');
                    }
                    if ($request->type == "recommended") {
                        $getsearchitems = $getsearchitems->inRandomOrder();
                    }
                    if ($request->type == "topdeals") {
                        if (@helper::checkaddons('top_deals')) {
                            if ($topdeals != null && $topdeals->top_deals_switch == 1) {
                                $getsearchitems = $getsearchitems->where('item.is_top_deals', '1')->where('item.price', '>', $offer_price)->orderBy('item.reorder_id');
                            } else {
                                abort(404);
                            }
                        } else {
                            abort(404);
                        }
                    }
                }
                if ($request->has('filter') && $request->filter != "") {
                    if ($request->filter == "veg") {
                        $getsearchitems = $getsearchitems->where('item.item_type', 1);
                    }
                    if ($request->filter == "nonveg") {
                        $getsearchitems = $getsearchitems->where('item.item_type', 2);
                    }
                }
                $getsearchitems = $getsearchitems->paginate(15);
            }
        } else {
            if ($request->has('type') && $request->type != "" && in_array($request->type, array('todayspecial', 'topitems', 'recommended', 'topdeals'))) {
                $getsearchitems = Item::with('category_info', 'subcategory_info', 'item_image')
                    ->select('item.*',
                        DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"),
                        DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'),
                        DB::raw('count(order_details.item_id) as item_order_counter'))
                    ->leftJoin('item_prices', function ($query) use ($branchId) {
                        $query->on('item_prices.item_id', '=', 'item.id')
                            ->where('item_prices.branch_id', '=', $branchId);
                    })
                    ->leftJoin('order_details', 'order_details.item_id', 'item.id')
                    ->leftJoin('cart', function ($query) use ($session_id) {
                        $query->on('cart.item_id', '=', 'item.id')
                            ->where('cart.session_id', '=', $session_id)
                            ->where('cart.buynow', '=', '0');
                    })->where(function ($query) {
                        $branchId = \Illuminate\Support\Facades\Session::get('branch_id');
                        $query->where('branch_ids', 'like', "%,$branchId,%") // Match middle
                        ->orWhere('branch_ids', 'like', "$branchId,%") // Match start
                        ->orWhere('branch_ids', 'like', "%,$branchId") // Match end
                        ->orWhere('branch_ids', '=', $branchId);
                    })
                    ->groupBy('item.id', 'cart.item_id')->where('item.item_status', '1');
                if ($request->has('type') && $request->type != "") {
                    if ($request->type == "todayspecial") {
                        $getsearchitems = $getsearchitems->where('item.is_featured', '1')->orderBy('item.reorder_id');
                    }
                    if ($request->type == "topitems") {
                        $getsearchitems = $getsearchitems->orderByDesc('item_order_counter');
                    }
                    if ($request->type == "recommended") {
                        $getsearchitems = $getsearchitems->inRandomOrder();
                    }
                    if ($request->type == "topdeals") {
                        if (@helper::checkaddons('top_deals')) {
                            if ($topdeals != null && $topdeals->top_deals_switch == 1) {
                                $getsearchitems = $getsearchitems->where('item.is_top_deals', '1')->where('item.price', '>', $offer_price)->orderBy('item.reorder_id');
                            } else {
                                abort(404);
                            }
                        } else {
                            abort(404);
                        }
                    }
                }
                if ($request->has('filter') && $request->filter != "") {
                    if ($request->filter == "veg") {
                        $getsearchitems = $getsearchitems->where('item.item_type', 1);
                    }
                    if ($request->filter == "nonveg") {
                        $getsearchitems = $getsearchitems->where('item.item_type', 2);
                    }
                }
                $getsearchitems = $getsearchitems->paginate(15);
            }
        }

        return view('web.viewall', compact('getsearchitems', 'topdeals'));

    }

public function deals(Request $request)
    {
        $user_id = @Auth::user()->id;
        $session_id = Session::getId();
        $branchId = Session::get('branch_id');
        $currentDateTime = now(); // Get the current date and time


        $getsearchitems = TopDeals::with('product')
            ->join('item', 'top_deals.product_id', '=', 'item.id')
            ->leftJoin('cart', function ($query) use ($session_id) {
                $query->on('cart.item_id', '=', 'item.id')
                    ->where('cart.user_id', '=', $session_id)
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
                'item.*',
                'cart.id as cart_id',
                'item_prices.price as dealPrice'
            )
            ->groupBy('item.id') // Ensuring each item appears only once
            ->get();


        return view('web.deals', compact('getsearchitems'));

    }

    public function getitemallergens(Request $request)
    {
        $itemAllergens = Item::where('id', $request->item_id)->first()->item_allergens;
        return response()->json(['item_allergens' => $itemAllergens]);
    }
}
