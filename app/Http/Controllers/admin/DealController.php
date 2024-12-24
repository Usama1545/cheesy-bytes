<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Sides;
use App\Models\TopDeals;
use Illuminate\Http\Request;

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
}
