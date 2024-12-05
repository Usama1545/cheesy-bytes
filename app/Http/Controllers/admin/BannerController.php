<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Item;
use App\Models\Category;

class BannerController extends Controller
{
    public function index()
    {
        $getbanner = Banner::orderBy('reorder_id')->get();
        return view('admin.banner.banner', compact('getbanner'));
    }
    public function add()
    {
        $getitem = Item::where('item_status', '1')->orderBy('reorder_id')->get();
        $getcategory = Category::where('is_available', '1')->orderBy('reorder_id')->get();
        return view('admin.banner.add', compact('getitem', 'getcategory'));
    }
    public function store(Request $request)
    {
        $image = 'banner-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(env('ASSETSPATHURL') . 'admin-assets/images/banner', $image);
        $banner = new Banner;
        $banner->image = $image;
        $banner->section = $request->section;
        if ($request->type == "1") {
            $banner->type = $request->type;
            $banner->item_id = "";
            $banner->cat_id = $request->cat_id;
        } else if ($request->type == "2") {
            $banner->type = $request->type;
            $banner->cat_id = "";
            $banner->item_id = $request->item_id;
        } else {
            $banner->cat_id = "";
            $banner->item_id = "";
            $banner->type = "";
        }
        $banner->save();
        return redirect('admin/bannersection-' . $request->section)->with('success', trans('messages.success'));
    }
    public function show(Request $request)
    {
        $getbanner = Banner::find($request->id);
        $getitem = Item::where('item_status', '1')->orderBy('reorder_id')->get();
        $getcategory = Category::where('is_available', '1')->orderBy('reorder_id')->get();
        return view('admin.banner.edit', compact('getbanner', 'getitem', 'getcategory'));
    }
    public function update(Request $request)
    {
        $banner = Banner::find($request->id);
        if ($request->type == "1") {
            $banner->type = $request->type;
            $banner->item_id = "";
            $banner->cat_id = $request->cat_id;
        } else if ($request->type == "2") {
            $banner->type = $request->type;
            $banner->cat_id = "";
            $banner->item_id = $request->item_id;
        } else {
            $banner->cat_id = "";
            $banner->item_id = "";
            $banner->type = "";
        }
        if (isset($request->image)) {
            if ($request->hasFile('image')) {
                if (file_exists(env('ASSETSPATHURL') . 'admin-assets/images/banner/' . $banner->image)) {
                    unlink(env('ASSETSPATHURL') . 'admin-assets/images/banner/' . $banner->image);
                }
                $image = $request->file('image');
                $image = 'banner-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(env('ASSETSPATHURL') . 'admin-assets/images/banner', $image);
                $banner->image = $image;
                $banner->save();
            }
        }
        $banner->save();
        return redirect('admin/bannersection-' . $request->section)->with('success', trans('messages.success'));
    }
    public function status(Request $request)
    {
        $checksbanner = Banner::where('id', $request->id)->update(['is_available' => $request->status]);
        if ($checksbanner) {
            return 1;
        } else {
            return 0;
        }
    }

    public function destroy(Request $request)
    {
        $banner = Banner::where('id', $request->id)->first();
        $updatebanner = Banner::where('id', $request->id)->delete();
        if ($updatebanner) {
            if (file_exists(env('ASSETSPATHURL') . 'admin-assets/images/banner/' . $banner->image)) {
                unlink(env('ASSETSPATHURL') . 'admin-assets/images/banner/' . $banner->image);
            }
            return 1;
        } else {
            return 0;
        }
    }
    public function reorder_banner(Request $request)
    {
        $getbanner = Banner::all();
        foreach ($getbanner as $banner) {
            foreach ($request->order as $order) {
                $banner = Banner::where('id', $order['id'])->first();
                $banner->reorder_id = $order['position'];
                $banner->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => 'Update Successfully!!'], 200);
    }
}
