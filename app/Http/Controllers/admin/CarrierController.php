<?php

namespace App\Http\Controllers\admin;

use App\Models\Carrier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Item;
use App\Models\Cart;
use App\Models\Extra;
use App\Models\ItemImages;
use Illuminate\Support\Str;

class CarrierController extends Controller
{
    public function index()
    {
        $getcategory = Carrier::orderBy('reorder_id')->get();
        return view('admin.carrier.category', compact('getcategory'));
    }
    public function add()
    {
        return view('admin.carrier.add');
    }
    public function store(Request $request)
    {
        $image = 'category-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(env('ASSETSPATHURL') . 'admin-assets/images/category', $image);
        $category = new Carrier;
        $category->image = $image;
        $category->name = $request->category_name;
        $category->branch_id = $request->branch_id;
        $category->link = $request->link;
        $category->save();
        return redirect('admin/carrier')->with('success', trans('messages.success'));
    }
    public function show(Request $request)
    {
        $catdata = Carrier::where('id', $request->id)->first();
        return view('admin.carrier.edit', compact('catdata'));
    }
    public function edit(Request $request)
    {
        $catdata = Carrier::where('id', $request->id)->first();
        return view('admin.carrier.edit', compact('catdata'));
    }
    public function update(Request $request)
    {
        $category = Carrier::find($request->id);
        if ($request->file('image') != "") {
            if (file_exists(env('ASSETSPATHURL') . 'admin-assets/images/category/' . $category->image)) {
                unlink(env('ASSETSPATHURL') . 'admin-assets/images/category/' . $category->image);
            }
            $image = 'category-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(env('ASSETSPATHURL') . 'admin-assets/images/category', $image);
            $category->image = $image;
            $category->save();
        }
        $category->name = $request->category_name;
        $category->branch_id = $request->branch_id;
        $category->link = $request->link;

        $category->save();
        return redirect('admin/carrier')->with('success', trans('messages.success'));
    }
    public function status(Request $request)
    {
        $category = Carrier::where('id', $request->id)->update(array('is_available' => $request->status));
        if ($category) {
            return 1;
        } else {
            return 0;
        }
    }
    public function delete(Request $request)
    {
        $category = Carrier::where('id', $request->id)->first();
        if ($category) {
            Carrier::where('id', $category->id)->delete();
            if (file_exists(env('ASSETSPATHURL') . 'admin-assets/images/category/' . $category->image)) {
                unlink(env('ASSETSPATHURL') . 'admin-assets/images/category/' . $category->image);
            }
            return 1;
        } else {
            return 0;
        }
    }


    public function reorder_category(Request $request)
    {
        $getcategory = Carrier::all();
        foreach ($getcategory as $category) {
            foreach ($request->order as $order) {
                $category = Carrier::where('id', $order['id'])->first();
                $category->reorder_id = $order['position'];
                $category->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => 'Update Successfully!!'], 200);
    }

    // subcategory

}
