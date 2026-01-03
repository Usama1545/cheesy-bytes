<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BmsmDealProduct;
use App\Models\DealCategory;
use App\Models\DealItem;
use App\Models\Item;
use App\Models\TopDeals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class DealController extends Controller
{
    // List all deals
    public function index()
    {
        $deals = TopDeals::with('product')->whereNot('deal_type', 1)->whereNot('deal_type', 3)->orderBy('id', 'desc')->get();
        return view('admin.topDeals.item', compact('deals'));
    }

    public function additem()
    {

        return view('admin.topDeals.additem');
    }

    // Create a new deal
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'product_id' => 'required|exists:item,id',
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:item,id',
            'size_id' => 'required|array',
            'size_id.*' => 'exists:sizes,id',
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required|date_format:H:i',
            'offer_type' => 'required|in:1,2',
            'offer_amount' => 'required|numeric|min:0',
            'order' => 'required|integer|min:1',
            'web_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,avif,webp|max:2048',
            'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,avif,webp|max:2048',
        ]);
        
        $slug = Item::find($request->product_id)->slug;
        $slugexists = TopDeals::where('slug', $slug)->exists();
        if ($slugexists) {
            $slug = $slug . '-' . uniqid();
        }

        $image = 'deal-' . uniqid() . '.' . $request->web_image->getClientOriginalExtension();
        $mobile_image = 'deal-' . uniqid() . '.' . $request->mobile_image->getClientOriginalExtension();
        $request->web_image->move(env('ASSETSPATHURL') . 'admin-assets/images', $image);
        $request->mobile_image->move(env('ASSETSPATHURL') . 'admin-assets/images', $mobile_image);

        $item = Item::find($request->product_id)->item_image();
        
        // dd($slug);

        $deal = TopDeals::create([
            'slug' => $slug,
            'product_id' => $request->product_id,
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
            'end_date' => $request->end_date,
            'end_time' => $request->end_time,
            'offer_type' => $request->offer_type,
            'offer_amount' => $request->offer_amount,
            'order' => $request->order,
            'size_id' => implode(',', $request->size_id),
            'product_ids'=> implode(',', $request->product_ids),
            'web_image' => $image,
            'mobile_image' => $mobile_image,
        ]);

        return redirect('admin/topDeals')->with('success', 'Deal created successfully!');
    }

    public function edititem($id)
    {
        $getitem = TopDeals::with('product')->findOrFail($id);

        return view('admin.topDeals.edititem', compact('getitem'));
    }

    // Get a single deal
    public function show($id)
    {
        $deal = TopDeals::with('product')->findOrFail($id);
        return response()->json($deal);
    }

    // Update an existing deal
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:top_deals,id',
            'product_id' => 'required|exists:item,id',
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:item,id',
            'size_id' => 'required|array',
            'size_id.*' => 'exists:sizes,id',
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required',
            'offer_type' => 'required|in:1,2',
            'offer_amount' => 'required|numeric|min:0',
            'order' => 'required|integer|min:1',
            'web_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,avif,webp|max:2048',
            'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,avif,webp|max:2048',
        ]);

        $deal = TopDeals::findOrFail($request->id);
        $image = $deal->web_image;
        $mobile_image = $deal->mobile_image;
        if ($request->file('web_image') != "") {
            $image = 'deal-' . uniqid() . '.' . $request->web_image->getClientOriginalExtension();
            $request->web_image->move(env('ASSETSPATHURL') . 'admin-assets/images', $image);
        }
        if ($request->file('mobile_image') != "") {
            $mobile_image = 'deal-' . uniqid() . '.' . $request->mobile_image->getClientOriginalExtension();
            $request->mobile_image->move(env('ASSETSPATHURL') . 'admin-assets/images', $mobile_image);
        }
       
        // Generate slug from product
        if ($request->filled('product_id')) {
            $slug = Item::findOrFail($request->product_id)->slug;

            $slugExists = TopDeals::where('slug', $slug)
                ->where('id', '!=', $deal->id)
                ->exists();

            if ($slugExists) {
                $slug = $slug . '-' . $deal->id;
            }

            $request->merge(['slug' => $slug]);
        }

        $deal->update([
            'product_id' => $request->product_id,
            'slug' => $request->slug,
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
            'end_date' => $request->end_date,
            'end_time' => $request->end_time,
            'offer_type' => $request->offer_type,
            'offer_amount' => $request->offer_amount,
            'order' => $request->order,
            'size_id' => implode(',', $request->size_id),
            'product_ids'=> implode(',', $request->product_ids),
            'web_image' => $image,
            'mobile_image' => $mobile_image,

        ]);

        return redirect('admin/topDeals')->with('success', 'Deal updated successfully!');
    }

    // Delete a deal
    public function destroy($id)
    {
        $deal = TopDeals::findOrFail($id);
        $deal->delete();

        return response()->json(['message' => 'Deal deleted successfully!']);
    }

    // Activate/Deactivate a deal
    public function toggleActive($id)
    {
        $deal = TopDeals::findOrFail($id);
        $deal->is_active = !$deal->is_active;
        $deal->save();

        return response()->json(['message' => 'Deal status updated!', 'is_active' => $deal->is_active]);
    }

    // Filter active deals
    public function activeDeals()
    {
        $now = now();
        $deals = TopDeals::where('is_active', true)
            ->whereDate('start_date', '<=', $now->toDateString())
            ->whereDate('end_date', '>=', $now->toDateString())
            ->get();

        return response()->json($deals);
    }

    public function delete(Request $request)
    {
        $category = TopDeals::where('id', $request->id)->first();
        if ($category) {
            $category->delete();
            return 1;
        }
        return 0;
    }

    public function dealDetails($id)
    {
        $branchId = Session::get('branch_id');
        $user_id = Session::get('user_id'); // Ensure user_id is fetched correctly
        $session_id = Session::getId();
        $topDealData = TopDeals::where('id', $id)->first();

        // Fetch top deals by ID
        $topDeals = TopDeals::where('id', $id)->pluck('product_ids')->first();
        $productIds = explode(',', $topDeals); // Convert comma-separated string to array
        $getitemdata = Item::with('category_info', 'subcategory_info', 'item_images', 'pizzaPrices', 'item_image')
            ->select(
                'item.*',
                DB::raw("
                CASE
                    WHEN category_info.category_name = 'pizza' THEN (
                        SELECT pp.price
                        FROM pizza_prices AS pp
                        WHERE FIND_IN_SET(pp.size_id, '$topDealData->size_id')
                            AND pp.item_id = item.id
                            AND pp.branch_id = $branchId
                        ORDER BY pp.price ASC -- Adjust based on your preference (MIN, MAX, etc.)
                        LIMIT 1
                    )
                    ELSE MAX(
                        CASE WHEN item_prices.branch_id = $branchId
                        THEN COALESCE(item_prices.price, 0) ELSE 0 END
                    )
                END AS item_price
            "),
                DB::raw('(CASE WHEN cart.item_id IS NULL THEN 0 ELSE 1 END) AS is_cart'),
                DB::raw('(CASE WHEN cart.item_id IS NULL THEN 0 ELSE cart.qty END) AS cartQty')

            )
            ->leftJoin('categories as category_info', 'category_info.id', '=', 'item.cat_id')
            ->where(function ($query) use ($branchId) {
                $query->where('item.branch_ids', 'like', "%,$branchId,%") // Match middle
                ->orWhere('item.branch_ids', 'like', "$branchId,%")    // Match start
                ->orWhere('item.branch_ids', 'like', "%,$branchId")    // Match end
                ->orWhere('item.branch_ids', '=', $branchId);          // Exact match
            })
            ->leftJoin('item_prices', function ($query) use ($branchId) {
                $query->on('item_prices.item_id', '=', 'item.id')
                    ->where('item_prices.branch_id', '=', $branchId);
            })
            ->leftJoin('cart', function ($query) use ($session_id, $user_id) {
                if ($user_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.user_id', '=', $user_id)
                        ->where('cart.buynow', '=', '0');
                } else {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.session_id', '=', $session_id)
                        ->where('cart.buynow', '=', '0');
                }
            })
            ->where(function ($query) use ($productIds) {
                $query->whereIn('item.id', $productIds);
            })
            ->groupBy('item.id') // Ensure unique rows per item
            ->get();

        // Sort by subcategory_info.reorder_id and group by subcategory_name or category_name
        $getitemdata = $getitemdata->sortBy(function ($item) {
            return $item->subcategory_info->reorder_id ?? PHP_INT_MAX; // Default to max value if reorder_id is not set
        });

        // Group by subcategory_name or category_name if subcategory_name is not available
        $groupedData = $getitemdata->groupBy(function ($item) {
            return $item->category_info->category_name;
        });

        // Final result formatting
        $result = $groupedData->map(function ($items, $name) use ($topDealData, $id) {
            return [
                'category_name' => $name,
                'items' => $items,
                'size_id' => $topDealData->size_id,
                'deal_id' => $id,
                'deal_type' => $topDealData->deal_type,
            ];
        })->values();

        return $result;
    }

    public function bogoDealDetails($branch, $slug)
    {
        try {
        $branchId = Session::get('branch_id');
        $user_id = Session::get('user_id');
        $session_id = Session::getId();
        $id = TopDeals::where('slug', $slug)->pluck('id')->first();

        $topDealData = TopDeals::with('product')->findOrFail($id);
        $dealType = $topDealData->deal_type;
        $dealSizeID = $topDealData->size_id ?? 1;

        $dealCategories = collect();
        $productIds = [];
        $dealItems = DealItem::where('deal_id', $id)->get()->keyBy('item_id');

        if ($dealType == 3) {
            // BOGO Deal
            $productIds = $dealItems->pluck('item_id')->toArray();

          $dealCategories = DealCategory::where('deal_id', $id)
                ->with([
                    'category',
                    'dealItem' => function ($dealItemQ) use ($branchId) {
                        $dealItemQ->whereHas('item', function ($q) use ($branchId) {
                            $q->whereRaw("FIND_IN_SET(?, item.branch_ids)", [$branchId])
                            ->where(function ($subQ) use ($branchId) {
                                $subQ->whereHas('itemPrices', function ($sub) use ($branchId) {
                                    $sub->where('branch_id', $branchId);
                                })
                                ->orWhereHas('pizzaPrices', function ($sub) use ($branchId) {
                                    // This needs to be handled differently - see alternative below
                                    $sub->where('branch_id', $branchId)
                                        ->where('price', '>', 0);
                                });
                            });
                        })
                        ->with([
                            'item' => function ($q) use ($branchId) {
                                $q->whereRaw("FIND_IN_SET(?, item.branch_ids)", [$branchId])
                                ->with([
                                    'itemPrices' => function ($sub) use ($branchId) {
                                        $sub->where('branch_id', $branchId);
                                    },
                                    'pizzaPrices' => function ($sub) use ($branchId) {
                                        $sub->where('branch_id', $branchId);
                                        // Size filtering will be done after data is loaded
                                    }
                                ]);
                            }
                        ]);
                    }
                ])
                ->get()
                ->map(function ($dealCategory) use ($branchId) {
                    // Filter pizzaPrices based on the dealCategory's size_id
                    if ($dealCategory->dealItem) {
                        $dealCategory->dealItem->each(function ($dealItem) use ($dealCategory, $branchId) {
                            if ($dealItem->item && $dealItem->item->pizzaPrices) {
                                $dealItem->item->pizzaPrices = $dealItem->item->pizzaPrices->filter(function ($pizzaPrice) use ($dealCategory, $branchId) {
                                    return $pizzaPrice->branch_id == $branchId && 
                                        $pizzaPrice->size_id == $dealCategory->size_id;
                                });
                            }
                        });
                    }
                    return $dealCategory;
                })
                ->sortBy(fn($categoryMeta) => $categoryMeta->is_free ? 1 : 0);

        } elseif ($dealType == 4) {
            // BMSM Deal
            $productIds = BmsmDealProduct::where('deal_id', $id)->pluck('item_id')->toArray();

        } elseif ($dealType == 1) {
            // Selective Deal
            $productIds = explode(',', $topDealData->product_ids);
        }

        // Get item IDs used in other deals for current user/session
        $cartItemIdsFromOtherDeals = DB::table('cart')
            ->join('top_deals', 'cart.deal_id', '=', 'top_deals.id')
            ->where('cart.deal_id', '!=', $id)
            ->when($user_id, fn($q) => $q->where('cart.user_id', $user_id),
                fn($q) => $q->where('cart.session_id', $session_id)
            )
            ->pluck('cart.item_id')
            ->toArray();
        $getitemdata = Item::whereRaw("FIND_IN_SET(?, item.branch_ids)", [$branchId])
        ->with('category_info', 'subcategory_info', 'item_images', 'pizzaPrices', 'item_image')
        ->select(
            'item.*',
            DB::raw("
                CASE 
                    WHEN category_info.category_name = 'pizza' 
                    THEN (
                        SELECT pp.price 
                        FROM pizza_prices AS pp 
                        WHERE FIND_IN_SET(pp.size_id, '$dealSizeID') 
                        AND pp.item_id = item.id 
                        AND pp.branch_id = $branchId 
                        ORDER BY pp.price ASC 
                        LIMIT 1
                    ) 
                    ELSE MAX(item_prices.price) 
                END AS item_price
            "),
            DB::raw('(CASE WHEN cart.item_id IS NULL OR cart.item_id IN (' . implode(',', $cartItemIdsFromOtherDeals ?: [0]) . ') THEN 0 ELSE 1 END) AS is_cart'),
            DB::raw('(CASE WHEN cart.item_id IS NULL OR cart.item_id IN (' . implode(',', $cartItemIdsFromOtherDeals ?: [0]) . ') THEN 0 ELSE cart.qty END) AS cartQty')
        )
        ->leftJoin('categories as category_info', 'category_info.id', '=', 'item.cat_id')
        ->leftJoin('item_prices', function ($query) use ($branchId) {
            $query->on('item_prices.item_id', '=', 'item.id')
                ->where('item_prices.branch_id', '=', $branchId);
        })
        ->leftJoin('cart', function ($query) use ($session_id, $user_id) {
            $query->on('cart.item_id', '=', 'item.id')
                ->where('cart.buynow', '=', '0');
            if ($user_id) {
                $query->where('cart.user_id', '=', $user_id);
            } else {
                $query->where('cart.session_id', '=', $session_id);
            }
        })
        ->whereIn('item.id', $productIds)
        ->where(function ($q) use ($branchId, $dealSizeID) {
            $q->whereExists(function ($sub) use ($branchId) {
                $sub->select(DB::raw(1))
                    ->from('item_prices')
                    ->whereRaw('item_prices.item_id = item.id')
                    ->where('item_prices.branch_id', $branchId);
            })
            ->orWhereExists(function ($sub) use ($branchId, $dealSizeID) {
                $sub->select(DB::raw(1))
                    ->from('pizza_prices')
                    ->whereRaw('pizza_prices.item_id = item.id')
                    ->where('pizza_prices.branch_id', $branchId)
                    ->whereRaw("FIND_IN_SET(pizza_prices.size_id, '$dealSizeID')");
            });
        })
        ->groupBy('item.id')
        ->get();

        // Group items by category name (not just cat_id)
        $getitemdata = $getitemdata->map(function ($item) use ($dealItems) {
            $dealMeta = $dealItems->get($item->id);
            $item->deal_meta = [
                'is_free'    => $dealMeta->is_free ?? 0,
                'is_required'=> $dealMeta->is_required ?? 0,
                'quantity'   => $dealMeta->quantity ?? 1,
                'deal_cat_id'=> $dealMeta->deal_category_id ?? null,
            ];
            return $item;
        });

        // 4. Now group by deal category (not just category name)
        $groupedData = $getitemdata->groupBy(fn($item) => $item->deal_meta['deal_cat_id'] ?? 'uncategorized');


        $result = collect();

        if ($dealType == 3) {
            // BOGO
            $dealCategories = $dealCategories->sortBy(function ($categoryMeta) {
                return $categoryMeta->is_free ? 1 : 0;
            });
            
            foreach ($dealCategories as $catId => $categoryMeta) {
                $catId = $categoryMeta->id;
                $categoryName = optional($categoryMeta->category)->category_name ?? 'Unknown';

                // items should match by cat_id + maybe size_id if relevant
                $items = $categoryMeta->dealItem->map(function ($dealItem) use ($categoryMeta) {
                    $item = $dealItem->item;

                    // pick pizzaPrice (matching size_id) else itemPrice
                    $price = null;

                    if ($item->pizzaPrices->isNotEmpty()) {
                        $pizzaPrice = $item->pizzaPrices
                            ->where('size_id', $categoryMeta->size_id)
                            ->first();
                        $price = $pizzaPrice?->price;
                    }

                    if (is_null($price) && $item->itemPrices->isNotEmpty()) {
                        $itemPrice = $item->itemPrices->first();
                        $price = $itemPrice?->price;
                    }

                    // Dynamically append custom attributes
                    $item->final_price = $price ?? 0;
                    $item->pizza_size = $categoryMeta->size_id;

                    return $item; // still an Eloquent model
                });


                $result->push([
                    'category_id'   => $catId,
                    'category_name' => $categoryName,
                    'items'         => $items,
                    'size_id'       => $categoryMeta->size_id,   // ✅ now per-rule
                    'offer_type'    => $topDealData->offer_type,
                    'offer_amount'  => $topDealData->offer_amount,
                    'deal_id'       => $id,
                    'deal_type'     => $dealType,
                    'category_meta' => [
                        'max'        => $categoryMeta->quantity,
                        'is_free'    => $categoryMeta->is_free,
                        'is_required'=> $categoryMeta->is_required, // ✅ include required flag
                        'unique'     => $categoryMeta->unique_products,
                    ],
                ]);
            }

            // dd($result);
            return view('web.deal-details', compact('result'));

        } else {
            // BMSM or Selective
            foreach ($groupedData as $categoryName => $items) {
                $result->push([
                    'category_id' => null,
                    'category_name' => $topDealData->product->item_name,
                    'items' => $items->values(),
                    'size_id' => $topDealData->size_id,
                    'offer_type' => $topDealData->offer_type,
                    'offer_amount' => $topDealData->offer_amount,
                    'deal_id' => $id,
                    'deal_type' => $dealType,
                    'category_meta' => null,
                ]);
            }
            return view('web.bmsm-deal-details', compact('result'));
        }
        } catch (\Exception $e) 
        {
            dd($e);
        }
    }

    public function flatDealDetails($branch, $slug)
    {
        try {
            $branchId = Session::get('branch_id');
            $user_id = Session::get('user_id');
            $session_id = Session::getId();
            
            // Get deal data
            $topDealData = TopDeals::with('product')->where('slug', $slug)->firstOrFail();
            $dealType = $topDealData->deal_type;
            $dealSizeIDs = $topDealData->size_id ?? '1';
            $productIds = explode(',', $topDealData->product_ids);
            
            // Validate we only handle flat deals (type 0 or 2)
            if (!in_array($dealType, [0, 2])) {
                abort(404, 'This deal type is not supported');
            }
            
            // Get cart items to check if already in cart
            $cartItemIdsFromOtherDeals = DB::table('cart')
                ->join('top_deals', 'cart.deal_id', '=', 'top_deals.id')
                ->where('cart.deal_id', '!=', $topDealData->id)
                ->when($user_id, fn($q) => $q->where('cart.user_id', $user_id),
                    fn($q) => $q->where('cart.session_id', $session_id)
                )
                ->pluck('cart.item_id')
                ->toArray();
            
            // Get product data with pricing
            $getitemdata = Item::whereRaw("FIND_IN_SET(?, item.branch_ids)", [$branchId])
                ->with('category_info', 'subcategory_info', 'item_images', 'pizzaPrices', 'item_image')
                ->select(
                    'item.*',
                    DB::raw("
                        CASE 
                            WHEN category_info.category_name = 'pizza' 
                            THEN (
                                SELECT pp.price 
                                FROM pizza_prices AS pp 
                                WHERE FIND_IN_SET(pp.size_id, '$dealSizeIDs') 
                                AND pp.item_id = item.id 
                                AND pp.branch_id = $branchId 
                                AND pp.price > 0
                                ORDER BY pp.price ASC 
                                LIMIT 1
                            ) 
                            ELSE (
                                SELECT ip.price 
                                FROM item_prices AS ip 
                                WHERE ip.item_id = item.id 
                                AND ip.branch_id = $branchId 
                                AND ip.price > 0
                                LIMIT 1
                            ) 
                        END AS item_price
                    "),
                    DB::raw('(CASE WHEN cart.item_id IS NULL OR cart.item_id IN (' . implode(',', $cartItemIdsFromOtherDeals ?: [0]) . ') THEN 0 ELSE 1 END) AS is_cart'),
                    DB::raw('(CASE WHEN cart.item_id IS NULL OR cart.item_id IN (' . implode(',', $cartItemIdsFromOtherDeals ?: [0]) . ') THEN 0 ELSE cart.qty END) AS cartQty')
                )
                ->leftJoin('categories as category_info', 'category_info.id', '=', 'item.cat_id')
                ->leftJoin('cart', function ($query) use ($session_id, $user_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.buynow', '=', '0');
                    if ($user_id) {
                        $query->where('cart.user_id', '=', $user_id);
                    } else {
                        $query->where('cart.session_id', '=', $session_id);
                    }
                })
                ->whereIn('item.id', $productIds)
                ->where(function ($q) use ($branchId, $dealSizeIDs) {
                    $q->whereExists(function ($sub) use ($branchId) {
                        $sub->select(DB::raw(1))
                            ->from('item_prices')
                            ->whereRaw('item_prices.item_id = item.id')
                            ->where('item_prices.branch_id', $branchId)
                            ->where('item_prices.price', '>', 0);
                    })
                    ->orWhereExists(function ($sub) use ($branchId, $dealSizeIDs) {
                        $sub->select(DB::raw(1))
                            ->from('pizza_prices')
                            ->whereRaw('pizza_prices.item_id = item.id')
                            ->where('pizza_prices.branch_id', $branchId)
                            ->where('pizza_prices.price', '>', 0)
                            ->whereRaw("FIND_IN_SET(pizza_prices.size_id, '$dealSizeIDs')");
                    });
                })
                ->groupBy('item.id')
                ->get();
            
            // Apply deal pricing based on offer_type
            $getitemdata->transform(function ($item) use ($topDealData) {
                $originalPrice = $item->item_price ?? 0;
                $dealPrice = $originalPrice;
                
                // Apply deal pricing logic
                if ($topDealData->offer_type == 1) {
                    // Fixed price offer
                    $dealPrice = $topDealData->offer_amount;
                } elseif ($topDealData->offer_type == 2) {
                    // Percentage discount
                    $discountAmount = ($originalPrice * $topDealData->offer_amount) / 100;
                    $dealPrice = $originalPrice - $discountAmount;
                }
                
                // Add deal pricing info
                $item->original_price = $originalPrice;
                $item->deal_price = max(0, round($dealPrice, 2));
                $item->deal_discount = $originalPrice - $item->deal_price;
                $item->offer_type = $topDealData->offer_type;
                $item->offer_amount = $topDealData->offer_amount;
                
                return $item;
            });
            
            // Prepare result structure
            $result = collect([
                [
                    'category_id' => null,
                    'category_name' => $topDealData->product->item_name ?? 'Deal Items',
                    'items' => $getitemdata->values(),
                    'size_ids' => explode(',', $dealSizeIDs),
                    'size_id' => $topDealData->size_id,
                    'offer_type' => $topDealData->offer_type,
                    'offer_amount' => $topDealData->offer_amount,
                    'deal_id' => $topDealData->id,
                    'deal_type' => $dealType,
                    'category_meta' => null,
                    'deal_details' => [
                        'name' => $topDealData->product->item_name ?? 'Deal',
                        'description' => $topDealData->description ?? '',
                        'valid_from' => $topDealData->valid_from,
                        'valid_to' => $topDealData->valid_to,
                    ]
                ]
            ]);

            // dd($result);
            
            // Return view based on deal type
           
            return view('web.flat-deal-details', compact('result'));
            
            
        } catch (\Exception $e) {
            // Better error handling in production
            // Log::error('Deal details error: ' . $e->getMessage());
            abort(404, 'Deal not found or unavailable');
        }
    }


    public function dealIndex()
    {
        $deals = TopDeals::with('product')->where('deal_type', 1)->orderBy('id', 'desc')->get();
        return view('admin.deals.item', compact('deals'));
    }

    public function addDealitem()
    {

        return view('admin.deals.additem');
    }

    // Create a new deal
    public function storeDeal(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:item,id',
            'offer_type' => 'nullable|in:1,2',
            'offer_amount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required|date_format:H:i',
            'is_active' => 'boolean',
            'product_ids' => 'required|array',
            'size_id' => 'required|exists:sizes,id', // Assuming size_id relates to the sizes table
            'min_count' => 'required|numeric|min:1',
            'order' => 'required|numeric|min:1',
            'web_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,avif,webp|max:2048',
            'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,avif,webp|max:2048',
        ]);

        $image = 'deal-' . uniqid() . '.' . $request->web_image->getClientOriginalExtension();
        $mobile_image = 'deal-' . uniqid() . '.' . $request->mobile_image->getClientOriginalExtension();
        $request->web_image->move(env('ASSETSPATHURL') . 'admin-assets/images', $image);
        $request->mobile_image->move(env('ASSETSPATHURL') . 'admin-assets/images', $mobile_image);

        $slug = Item::find($request->product_id)->slug;
        $slugexists = TopDeals::where('slug', $slug)->exists();
        if ($slugexists) {
            $slug = $slug . '-' .uniqid();
        }

        // Create a deal with default deal_type and formatted product_ids
        $deal = TopDeals::create([
            'slug' => $slug,
            'product_id' => $validatedData['product_id'],
            'offer_type' => $validatedData['offer_type'] ?? 1,
            'offer_amount' => $validatedData['offer_amount'] ?? 0,
            'start_date' => $validatedData['start_date'],
            'start_time' => $validatedData['start_time'],
            'end_date' => $validatedData['end_date'],
            'end_time' => $validatedData['end_time'],
            'is_active' => $validatedData['is_active'] ?? false,
            'product_ids' => implode(',', $validatedData['product_ids']),
            'size_id' => implode(',', $validatedData['size_id']),
            'min_count' => $validatedData['min_count'],
            'deal_type' => 1, // Default deal_type
            'order' => $validatedData['order'],
            'web_image' => $image,
            'mobile_image' => $mobile_image
        ]);

        return redirect('admin/deals')->with('success', 'Deal created successfully!');
    }

    public function editDealitem($id)
    {
        $getitem = TopDeals::with('product')->findOrFail($id);

        return view('admin.deals.edititem', compact('getitem'));
    }

    // Get a single deal
    public function showDeal($id)
    {
        $deal = TopDeals::with('product')->findOrFail($id);
        return response()->json($deal);
    }

    // Update an existing deal
    public function updateDeal(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:top_deals,id',
            'product_id' => 'sometimes|required|exists:item,id',
            'discount_type' => 'nullable|in:flat,percentage',
            'offer_amount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required',
            'is_active' => 'boolean',
            'product_ids' => 'required|array',
            'size_id' => 'required|exists:sizes,id', // Assuming size_id relates to sizes table
            'min_count' => 'required|numeric|min:1',
            'order' => 'required|numeric|min:1',
            'web_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,avif,webp|max:2048',
            'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,avif,webp|max:2048',
        ]);
        // Find the deal using validated ID
        $deal = TopDeals::findOrFail($request->id);
        $image = $deal->web_image;
        $mobile_image = $deal->mobile_image;
        if ($request->file('web_image') != "") {
            $image = 'deal-' . uniqid() . '.' . $request->web_image->getClientOriginalExtension();
            $request->web_image->move(env('ASSETSPATHURL') . 'admin-assets/images', $image);
        }
        if ($request->file('mobile_image') != "") {
            $mobile_image = 'deal-' . uniqid() . '.' . $request->mobile_image->getClientOriginalExtension();
            $request->mobile_image->move(env('ASSETSPATHURL') . 'admin-assets/images', $mobile_image);
        }
       
        // Generate slug from product
        if ($request->filled('product_id')) {
            $slug = Item::findOrFail($request->product_id)->slug;

            $slugExists = TopDeals::where('slug', $slug)
                ->where('id', '!=', $deal->id)
                ->exists();

            if ($slugExists) {
                $slug = $slug . '-' . $deal->id;
            }

            $request->merge(['slug' => $slug]);
        }
        
        $product_ids = implode(',', $validatedData['product_ids']);
        $size_ids = implode(',', $validatedData['size_id']);

        // Update deal with merged attributes
        $deal->update(array_merge(
            $validatedData,
            ['product_ids' => $product_ids, 'size_id' => $size_ids, 'web_image' => $image, 'mobile_image' => $mobile_image]
        ));
        $deal->save();

        return redirect('admin/deals')->with('success', 'Deal Updated successfully!');
    }

}
