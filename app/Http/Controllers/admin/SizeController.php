<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Sides;
use App\Models\Size;
use App\Models\TopDeals;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    // List all deals
    public function index()
    {
        $sizes = Size::orderBy('id', 'desc')->get();
        return view('admin.sizes.index', compact('sizes'));
    }

    public function additem()
    {

        return view('admin.sizes.add');
    }

    // Create a new deal
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'label' => 'required|integer'
        ]);
        Size::create($request->all());

        return redirect('admin/sizes')->with('success', 'Size created successfully!');
    }

    public function edititem($id)
    {
        $sizes = Size::findOrFail($id);

        return view('admin.sizes.edit', compact('sizes'));
    }

    // Get a single deal
    public function show($id)
    {
        $deal = Size::findOrFail($id);
        return response()->json($deal);
    }

    // Update an existing deal
    public function update(Request $request)
    {

        $request->validate([
            'id' => 'required|exists:sizes,id',
            'name' => 'required|string',
            'label' => 'required|string'
        ]);
        $deal = Size::findOrFail($request['id']);

        $deal->update($request->all());

        return redirect('admin/sizes')->with('success', 'Size Updated successfully!');
    }

    // Delete a deal
    public function destroy($id)
    {
        $deal = Size::findOrFail($id);
        $deal->delete();

        return response()->json(['message' => 'Size deleted successfully!']);
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
        $category = Size::where('id', $request->id)->first();
        if ($category) {
            $category->delete();
            return 1;
        }
        return 0;
    }
}
