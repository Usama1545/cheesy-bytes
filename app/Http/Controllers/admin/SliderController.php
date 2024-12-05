<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Item;
use App\Models\Category;

class SliderController extends Controller
{
    public function index()
    {
        $getslider = Slider::orderBy('reorder_id')->get();
        return view('admin.slider.slider', compact('getslider'));
    }
    public function list()
    {
        $getslider = Slider::orderBy('reorder_id')->get();
        return view('admin.slider.slidertable', compact('getslider'));
    }
    public function add()
    {
        $getitem = Item::where('item_status', '1')->orderBy('reorder_id')->get();
        $getcategory = Category::where('is_available', '1')->orderBy('reorder_id')->get();
        return view('admin.slider.add', compact('getitem', 'getcategory'));
    }
    public function store(Request $request)
    {
        $image = 'slider-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(env('ASSETSPATHURL') . 'admin-assets/images/slider', $image);
        $slider = new Slider;
        $slider->image = $image;
        $slider->title = $request->title;
        $slider->description = $request->description;
        if ($request->type == "1") {
            $slider->type = $request->type;
            $slider->item_id = 0;
            $slider->cat_id = $request->cat_id;
        } else if ($request->type == "2") {
            $slider->type = $request->type;
            $slider->cat_id = 0;
            $slider->item_id = $request->item_id;
        } else {
            $slider->cat_id = 0;
            $slider->item_id = 0;
            $slider->type = "";
        }
        $slider->is_available = 1;
        $slider->save();
        return redirect('admin/slider')->with('success', trans('messages.success'));
    }
    public function show(Request $request)
    {
        $getslider = Slider::find($request->id);
        $getitem = Item::where('item_status', '1')->orderBy('reorder_id')->get();
        $getcategory = Category::where('is_available', '1')->orderBy('reorder_id')->get();
        return view('admin.slider.edit', compact('getslider', 'getitem', 'getcategory'));
    }
    public function update(Request $request)
    {
        $slider = Slider::find($request->id);
        if ($request->file('image') != "") {
            if (file_exists(env('ASSETSPATHURL') . 'admin-assets/images/slider/' . $slider->image)) {
                unlink(env('ASSETSPATHURL') . 'admin-assets/images/slider/' . $slider->image);
            }
            $image = 'slider-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(env('ASSETSPATHURL') . 'admin-assets/images/slider', $image);
            $slider->image = $image;
            $slider->save();
        }
        $slider->title = $request->title;
        $slider->description = $request->description;
        if ($request->type == "1") {
            $slider->type = $request->type;
            $slider->item_id = 0;
            $slider->cat_id = $request->cat_id;
        } else if ($request->type == "2") {
            $slider->type = $request->type;
            $slider->cat_id = 0;
            $slider->item_id = $request->item_id;
        } else {
            $slider->cat_id = 0;
            $slider->item_id = 0;
            $slider->type = "";
        }
        $slider->save();
        return redirect('admin/slider')->with('success', trans('messages.success'));
    }
    public function status(Request $request)
    {
        $checkslider = Slider::where('id', $request->id)->update(['is_available' => $request->status]);
        if ($checkslider) {
            return 1;
        } else {
            return 0;
        }
    }
    public function destroy(Request $request)
    {
        $checkslider = Slider::where('id', $request->id)->first();
        $deleteslider = Slider::where('id', $request->id)->delete();
        if ($deleteslider) {
            if (file_exists(env('ASSETSPATHURL') . 'admin-assets/images/slider/' . $checkslider->image)) {
                unlink(env('ASSETSPATHURL') . 'admin-assets/images/slider/' . $checkslider->image);
            }
            return 1;
        } else {
            return 0;
        }
    }
    public function reorder_slider(Request $request)
    {
        $getslider = Slider::all();
        foreach ($getslider as $slider) {
            foreach ($request->order as $order) {
                $slider = Slider::where('id', $order['id'])->first();
                $slider->reorder_id = $order['position'];
                $slider->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => 'Update Successfully!!'], 200);
    }
}
