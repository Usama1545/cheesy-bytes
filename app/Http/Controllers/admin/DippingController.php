<?php

namespace App\Http\Controllers\admin;

use App\Models\Sides;
use App\Models\CustomPizzaSauce;
use App\Models\CustomPizzaSize;
use App\Models\CustomPizzaTopping;
use App\Models\TopDeals;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DippingController extends Controller
{
    public function index(Request $request)
    {
        $getitem = Sides::all();
        return view('admin.dipping.item', compact('getitem'));
    }

    public function additem()
    {
        return view('admin.dipping.additem');
    }

    public function edititem($id)
    {
        $getitem = Sides::findOrFail($id);

        return view('admin.dipping.edititem', compact('getitem'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $image = 'dipping-' . uniqid() . '.' . $validated['image']->getClientOriginalExtension();
        $request->image->move(env('ASSETSPATHURL') . 'admin-assets/images/category', $image);
        $size = new Sides();
        $size->name = $validated['name'];
        $size->price = $validated['price'];
        $size->image = $image;
        $size->save();

        return redirect('admin/dipping')->with('success', 'pizza Dipping created successfully!');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|numeric',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $image = 'dipping-' . uniqid() . '.' . $validated['image']->getClientOriginalExtension();
        $request->image->move(env('ASSETSPATHURL') . 'admin-assets/images/category', $image);
        $size = Sides::findOrFail($validated['id']);
        $size->name = $validated['name'];
        $size->price = $validated['price'];
        $size->image = $image;
        $size->save();


        return redirect('admin/dipping')->with('success', 'pizza Dipping Updated successfully!');

    }
    public function delete(Request $request)
    {
        $category = Sides::where('id', $request->id)->first();
        if($category){
            $category->delete();
            return 1;
        }
        return 0;
    }
}
