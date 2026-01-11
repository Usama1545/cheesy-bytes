<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Crust;
use App\Models\Item;
use App\Models\Sides;
use App\Models\Size;
use App\Models\TopDeals;
use Illuminate\Http\Request;

class CrustController extends Controller
{
    // List all deals
    public function index()
    {
        $crusts = Crust::orderBy('id', 'desc')->get();
        return view('admin.crusts.index', compact('crusts'));
    }

    public function additem()
    {

        return view('admin.crusts.add');
    }

    // Create a new deal
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
        Crust::create($request->all());

        return redirect('admin/crusts')->with('success', 'Crust created successfully!');
    }

    public function edititem($id)
    {
        $crusts = Crust::findOrFail($id);

        return view('admin.crusts.edit', compact('crusts'));
    }

    // Get a single deal
    public function show($id)
    {
        $deal = Crust::findOrFail($id);
        return response()->json($deal);
    }

    // Update an existing deal
    public function update(Request $request)
    {

        $request->validate([
            'id' => 'required|exists:crusts,id',
            'name' => 'required|string',
        ]);
        $deal = Crust::findOrFail($request['id']);

        $deal->update($request->all());

        return redirect('admin/crusts')->with('success', 'Crust Updated successfully!');
    }

    // Delete a deal
    public function destroy($id)
    {
        $deal = Crust::findOrFail($id);
        $deal->delete();

        return response()->json(['message' => 'Crust deleted successfully!']);
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
        $category = Crust::where('id', $request->id)->first();
        if ($category) {
            $category->delete();
            return 1;
        }
        return 0;
    }
}
