<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BmsmDealProduct;
use App\Models\BmsmDealTier;
use App\Models\DealCategory;
use App\Models\Item;
use App\Models\TopDeals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class BmsmDealController extends Controller
{
    // List all deals
    public function index()
    {
        $deals = TopDeals::with('product')->where('deal_type', 4)->orderBy('id', 'desc')->get();
        return view('admin.bmsmDeals.item', compact('deals'));
    }

    public function additem()
    {

        return view('admin.bmsmDeals.additem');
    }

    // Create a new deal
    public function store(Request $request)
    {
        // Validate basic deal fields
        $request->validate([
            'product_id' => 'required|exists:item,id',
            'product_ids' => 'nullable|array',
            'offer_type' => 'required|in:1,2',
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required|date_format:H:i',
            'order' => 'required|numeric|min:1',
            'bmsm_deal_type' => 'required|in:1,2', // 1 = product, 2 = cart
            'tiers' => 'required|array|min:1',
            'tiers.*.min_qty' => 'required|numeric|min:1',
            'tiers.*.max_qty' => 'required|numeric|min:1|gte:tiers.*.min_qty',
            'tiers.*.discount_value' => 'required|numeric|min:0',
            'web_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,avif,webp|max:2048',
            'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,avif,webp|max:2048',
        ]);

        $image = 'deal-' . uniqid() . '.' . $request->web_image->getClientOriginalExtension();
        $mobile_image = 'deal-' . uniqid() . '.' . $request->mobile_image->getClientOriginalExtension();
        $request->web_image->move(env('ASSETSPATHURL') . 'admin-assets/images', $image);
        $request->mobile_image->move(env('ASSETSPATHURL') . 'admin-assets/images', $mobile_image);

        $deal = TopDeals::create([
            'product_id' => $request->product_id,
            'offer_type' => $request->offer_type,
            'offer_amount' => 0, // Ignored for BMSM
            'deal_type' => 4, // BMSM
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
            'end_date' => $request->end_date,
            'end_time' => $request->end_time,
            'order' => $request->order,
            'bmsm_deal_type' => $request->bmsm_deal_type,
            'web_image' => $image,
            'mobile_image' => $mobile_image,

        ]);

        $slug = Item::find($request->product_id)->slug;
        $slugexists = TopDeals::where('slug', $slug)->exists();
        if ($slugexists) {
            $slug = $slug . '-' .$deal->id;
        }

        $deal->update([
            'slug' => $slug,
        ]);
        // Create the main deal
        
         if ($request->product_ids) {
            foreach ($request->product_ids as $product_id) {
                BmsmDealProduct::create([
                    'deal_id' => $deal->id,
                    'item_id' => $product_id,
                ]);
            }
        }
        // Attach BMSM tiers
        foreach ($request->tiers as $tier) {
            BmsmDealTier::create([
                'deal_id' => $deal->id,
                'min_qty' => $tier['min_qty'],
                'max_qty' => $tier['max_qty'],
                'discount_value' => $tier['discount_value'],
            ]);
        }

        return redirect('admin/bmsmDeals')->with('success', 'BMSM deal created successfully!');
    }

    public function edititem($id)
    {
        $getitem = TopDeals::with('product', 'bmsmTiers', 'bmsmProducts')->findOrFail($id);
        return view('admin.bmsmDeals.edititem', compact('getitem'));
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
            'product_id' => 'required|exists:item,id',
            'product_ids' => 'nullable|array',
            'offer_type' => 'required|in:1,2',
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i:s',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required|date_format:H:i:s',
            'order' => 'required|numeric|min:1',
            'bmsm_deal_type' => 'required|in:1,2', // 1 = product, 2 = cart
            'tiers' => 'required|array|min:1',
            'tiers.*.min_qty' => 'required|numeric|min:1',
            'tiers.*.max_qty' => 'required|numeric|min:1|gte:tiers.*.min_qty',
            'tiers.*.discount_value' => 'required|numeric|min:0',
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

        $slug = Item::find($request->product_id)->slug;
        $slugexists = TopDeals::where('slug', $slug)->exists();
        if ($slugexists) {
            $slug = $slug . '-' .$deal->id;
        }

        // Update base deal info
        $deal->update([
            'product_id' => $request->product_id,
            'slug' => $slug,
            'offer_type' => $request->offer_type,
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
            'end_date' => $request->end_date,
            'end_time' => $request->end_time,
            'size_id' => $request->size_id,
            'order' => $request->order,
            'bmsm_deal_type' => $request->bmsm_deal_type,
            'web_image' => $image,
            'mobile_image' => $mobile_image,
        ]);

        // Clean old relationships
        BmsmDealProduct::where('deal_id', $deal->id)->delete();
        BmsmDealTier::where('deal_id', $deal->id)->delete();
//dd($request->product_ids);
        if ($request->product_ids) {
            foreach ($request->product_ids as $product_id) {
                BmsmDealProduct::create([
                    'deal_id' => $deal->id,
                    'item_id' => $product_id,
                ]);
            }
        }
        // Attach BMSM tiers
        foreach ($request->tiers as $tier) {
            BmsmDealTier::create([
                'deal_id' => $deal->id,
                'min_qty' => $tier['min_qty'],
                'max_qty' => $tier['max_qty'],
                'discount_value' => $tier['discount_value'],
            ]);
        }

        return redirect('admin/bmsmDeals')->with('success', 'Deal updated successfully!');
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

        // Fetch top deals by ID
        $bogoDeals = TopDeals::where('id', $id)->pluck('product_ids')->first();
        $productIds = explode(',', $bogoDeals); // Convert comma-separated string to array
        $getitemdata = Item::with('category_info', 'subcategory_info', 'item_images', 'item_image')
            ->select(
                'item.*',
                DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"),
                DB::raw('(CASE WHEN cart.item_id IS NULL THEN 0 ELSE 1 END) AS is_cart'),
                DB::raw('(CASE WHEN cart.item_id IS NULL THEN 0 ELSE cart.qty END) AS cartQty')
            )
            ->where(function ($query) use ($branchId) {
                $query->where('branch_ids', 'like', "%,$branchId,%") // Match middle
                ->orWhere('branch_ids', 'like', "$branchId,%")    // Match start
                ->orWhere('branch_ids', 'like', "%,$branchId")    // Match end
                ->orWhere('branch_ids', '=', $branchId);           // Exact match
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
            ->whereIn('item.id', $productIds)
            ->groupBy('item.id') // Ensure unique rows per item
            ->get();

        $groupedData = $getitemdata->groupBy(function ($item) {
            return $item->category_info->category_name; // Assuming 'name' is the category name field
        });
        $bogoDeals = TopDeals::where('id', $id)->pluck('size_id')->first();

        $result = $groupedData->map(function ($items, $categoryName) use ($bogoDeals, $id) {
            return [
                'category_name' => $categoryName,
                'items' => $items,
                'size_id' => $bogoDeals,
                'deal_id' => $id,
            ];
        })->values();

        return $result;
    }
}
