<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Addons;
use App\Models\AddonsGroup;
use App\Models\Extra;
use App\Models\Item;
use App\Models\Sides;
use Session;
use App\Models\TopDeals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DealController extends Controller
{
    // List all deals
    public function index()
    {
        $deals = TopDeals::with('product')->orderBy('id', 'desc')->get();
        return view('admin.topDeals.item', compact('deals'));
    }

    public function additem()
    {

        return view('admin.topDeals.additem');
    }

    // Create a new deal
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:item,id',
            'offer_type' => 'required|in:1,2',
            'offer_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required|date_format:H:i',
            'is_active' => 'boolean',
        ]);

        $deal = TopDeals::create($request->all());

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
            'product_id' => 'sometimes|required|exists:item,id',
            'discount_type' => 'sometimes|required|in:flat,percentage',
            'offer_amount' => 'sometimes|required|numeric|min:0',
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i:s',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required|date_format:H:i:s',
            'is_active' => 'boolean',
        ]);
        $deal = TopDeals::findOrFail($request['id']);

        $deal->update($request->all());

        return redirect('admin/topDeals')->with('success', 'Deal Updated successfully!');    }

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
        if($category){
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
        $topDeals = TopDeals::where('id', $id)->pluck('product_ids')->first();
        $productIds = explode(',', $topDeals); // Convert comma-separated string to array
        if($user_id != null) {
            // Fetch items grouped by category and belonging to the selected branch
            $getitemdata = Item::with('category_info', 'subcategory_info', 'item_images', 'item_image')
                ->select(
                    'item.*',
                    DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"),
                    DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart')
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
                ->leftJoin('cart', function ($query) use ($user_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.user_id', '=', $user_id)
                        ->where('cart.buynow', '=', '0');
                })
                ->whereIn('item.id', $productIds)
                ->groupBy('item.cat_id')
                ->get();


        }else{
            $getitemdata = Item::with('category_info', 'subcategory_info', 'item_images', 'item_image')
                ->select(
                    'item.*',
                    DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"),
                    DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'),
                    DB::raw('(case when cart.item_id is null then 0 else cart.qty end) as cartQty')
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
                ->leftJoin('cart', function ($query) use ($session_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.session_id', '=', $session_id)
                        ->where('cart.buynow', '=', '0');
                })
                ->whereIn('item.id', $productIds)
                ->groupBy('item.cat_id')
                ->get();
            // Fetch addons grouped by addon groups
        }

        $groupedData = $getitemdata->groupBy(function ($item) {
            return $item->category_info->category_name; // Assuming 'name' is the category name field
        });
        $topDeals = TopDeals::where('id', $id)->pluck('size_id')->first();

        $result = $groupedData->map(function ($items, $categoryName) use ($topDeals,$id) {
            return [
                'category_name' => $categoryName,
                'items' => $items,
                'size_id' => $topDeals,
                'deal_id' => $id,
            ];
        })->values();

        return $result;
    }

}
