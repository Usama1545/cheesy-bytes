<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Crust;
use App\Models\Item;
use App\Models\PizzaPrice;
use App\Models\ProductSizeCrust;
use App\Models\Sides;
use App\Models\Size;
use App\Models\TopDeals;
use Illuminate\Http\Request;

class PizzaCrustController extends Controller
{
    // List all deals
    public function index()
    {
        $category = Category::where('category_name', 'Pizza')->first();
        $item = Item::orderBy('id', 'desc')->where('cat_id', $category->id)->get();
        return view('admin.pizza-pricing.index', compact('item'));
    }

    public function edititem($id)
    {
        $sizes = PizzaPrice::where('item_id', $id)->get();
        $crusts = ProductSizeCrust::where('item_id', $id)->get();

        $groupedData = $crusts->groupBy(function ($item) {
            return $item->size_id . '_' . $item->price; // Group by size_id and price
        })->map(function ($items, $key) {
            $firstItem = $items->first();
            return [
                'size_id' => $firstItem->size_id,
                'price' => $firstItem->price,
                'crust_ids' => $items->pluck('crust_id')->toArray(),
            ];
        })->values()->toArray();

        return view('admin.pizza-pricing.edit', compact('groupedData', 'id', 'sizes'));
    }


    // Update an existing deal
    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:item,id',
            'size_crusts' => 'required|array',
        ]);
        ProductSizeCrust::where('item_id', $data['id'])->delete();
        foreach ($data['size_crusts'] as $size_crust) {
            foreach ($size_crust['crusts'] as $crust) {
                ProductSizeCrust::updateOrCreate(
                    [
                        // Conditions to find the record
                        'item_id' => $data['id'],
                        'size_id' => $size_crust['size'],
                        'crust_id' => $crust,
                    ],
                    [
                        // Values to update or insert
                        'price' => $size_crust['price'],
                    ]
                );
            }
        }

//        $deal->update($request->all());

        return redirect('admin/pizza_crusts')->with('success', 'Pizza Crust and Size Updated successfully!');
    }

    public function updateSizePrice(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:item,id',
            'size_prices' => 'required|array',
        ]);
        PizzaPrice::where('item_id', $data['id'])->delete();
        foreach ($data['size_prices'] as $size_crust) {
            PizzaPrice::updateOrCreate(
                [
                    'item_id' => $data['id'],
                    'size_id' => $size_crust['size'],
                    'branch_id' => $size_crust['branch_id'],
                ],
                [
                    // Values to update or insert
                    'price' => $size_crust['price'],
                ]
            );
        }

//        $deal->update($request->all());

        return redirect('admin/pizza_crusts')->with('success', 'Pizza Crust and Size Updated successfully!');
    }

}
