<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DealCategory;
use App\Models\DealItem;
use App\Models\Item;
use App\Models\TopDeals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Session;

class BogoDealController extends Controller
{
    // List all deals
    public function index()
    {
        $deals = TopDeals::with('product')->where('deal_type', 3)->orderBy('id', 'desc')->get();
        return view('admin.bogoDeals.item', compact('deals'));
    }

    public function additem()
    {

        return view('admin.bogoDeals.additem');
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
            'order' => 'required|numeric|min:1',
            'deal_rules' => 'required|array',
        ]);

        $deal = TopDeals::create([
            'product_id' => $request->product_id,
            'offer_type' => $request->offer_type,
            'offer_amount' => $request->offer_amount,
            'deal_type' => 3,
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
            'end_date' => $request->end_date,
            'end_time' => $request->end_time,
            'size_id' => $request->size_id,
            'order' => $request->order,
        ]);

         $slug = Item::find($request->product_id)->slug;
        $slugexists = TopDeals::where('slug', $slug)->exists();
        if ($slugexists) {
            $slug = $slug . '-' .$deal->id;
        }

        $deal->update([
            'slug' => $slug,
        ]);
        foreach ($request->deal_rules as $deal_rule) {

            // Skip if no valid settings
            if (!$deal_rule || empty($deal_rule['max']) || empty($deal_rule['products']) || !is_array($deal_rule['products'])) {
                continue;
            }

            // Create deal category
            $dealCategory = $deal->dealCategory()->create([
                'category_id' => $deal_rule['category_id'],
                'quantity' => $deal_rule['max'],
                'unique_products' => isset($deal_rule['unique']) ? 1 : 0,
                'is_free' => isset($deal_rule['is_free']) ? 1 : 0,
                'size_id' => $deal_rule['size_id'],
                'is_required' => isset($deal_rule['is_free']) ? 0 : 1
            ]);

            // Create deal items
            foreach ($deal_rule['products'] as $itemId) {
                $deal->dealItem()->create([
                    'item_id' => $itemId,
                    'deal_category_id' => $dealCategory->id,
                ]);
            }
        }
        return redirect('admin/bogoDeals')->with('success', 'Deal created successfully!');
    }

    public function edititem($id)
    {
        $getitem = TopDeals::with('product', 'dealCategory', 'dealItem')->findOrFail($id);
        $deal_rules = $getitem->dealCategory->map(function ($category) use ($getitem) {
            return [
                'category_id' => $category->category_id,
                'products'    => $getitem->dealItem
                                    ->where('deal_category_id', $category->id)
                                    ->pluck('item_id')
                                    ->toArray(),
                'size_id'     => $category->size_id,
                'max'         => $category->quantity,
                'is_free'     => $category->is_free == 1,
                'unique'      => $category->unique_products == 1,
            ];
        })->toArray();
        return view('admin.bogoDeals.edititem', compact('getitem', 'deal_rules'));
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
        $validated = $request->validate([
            'id' => 'required|exists:top_deals,id',
            'product_id' => 'required|exists:item,id',
            'offer_type' => 'required|in:1,2',
            'offer_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required',
            'size_id' => 'nullable|integer|exists:sizes,id',
            'order' => 'required|numeric|min:1',
            'deal_rules' => 'required|array',
        ]);

        $deal = TopDeals::findOrFail($request->id);
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
            'offer_amount' => $request->offer_amount,
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
            'end_date' => $request->end_date,
            'end_time' => $request->end_time,
            'size_id' => $request->size_id,
            'order' => $request->order,
        ]);

        // Clean old relationships
        DealCategory::where('deal_id', $deal->id)->delete();
        DealItem::where('deal_id', $deal->id)->delete();

        // Recreate deal categories and items
        foreach ($request->deal_rules as $deal_rule) {

            // Skip if no valid settings
            if (!$deal_rule || empty($deal_rule['max']) || empty($deal_rule['products']) || !is_array($deal_rule['products'])) {
                continue;
            }

            // Create deal category
            $dealCategory = $deal->dealCategory()->create([
                'category_id' => $deal_rule['category_id'],
                'quantity' => $deal_rule['max'],
                'unique_products' => isset($deal_rule['unique']) ? 1 : 0,
                'is_free' => isset($deal_rule['is_free']) ? 1 : 0,
                'size_id' => $deal_rule['size_id'],
                'is_required' => isset($deal_rule['is_free']) ? 0 : 1
            ]);

            // Create deal items
            foreach ($deal_rule['products'] as $itemId) {
                $deal->dealItem()->create([
                    'item_id' => $itemId,
                    'deal_category_id' => $dealCategory->id,
                ]);
            }
        }

        return redirect('admin/bogoDeals')->with('success', 'Deal updated successfully!');
    }


    // Delete a deal
    public function destroy($id)
    {
        $deal = TopDeals::findOrFail($id);
        $deal->delete();

        DealCategory::where('deal_id', $id)->delete();
        DealItem::where('deal_id', $id)->delete();

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
        $deal = TopDeals::where('id', $request->id)->first();
        if ($deal) {
            $deal->delete();
            DealCategory::where('deal_id', $request->id)->delete();
            DealItem::where('deal_id', $request->id)->delete();

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
