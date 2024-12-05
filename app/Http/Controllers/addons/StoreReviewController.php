<?php

namespace App\Http\Controllers\addons;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ratting;
use Illuminate\Support\Facades\Auth;
use App\Helpers\helper;

class StoreReviewController extends Controller
{
    public function index()
    {
        if (@helper::checkaddons('store_review')) {
            $getstorereviewlist = Ratting::where('user_id', '1')->orderBy('reorder_id')->paginate(12);
            return view('admin.store_review.store_review', compact('getstorereviewlist'));
        } else {
            abort(404);
        }
    }
    public function add()
    {
        if (@helper::checkaddons('store_review')) {
            return view('admin.store_review.add');
        } else {
            abort(404);
        }
    }
    public function store(Request $request)
    {
        $image = 'store_review-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(env('ASSETSPATHURL') . 'admin-assets/images/reviews', $image);
        $store_review = new Ratting();
        $store_review->user_id = Auth::user()->id;
        $store_review->name = $request->name;
        $store_review->ratting = $request->ratting;
        $store_review->comment = $request->comment;
        $store_review->image = $image;
        $store_review->save();
        return redirect('admin/store-review')->with('success', trans('messages.success'));
    }
    public function show(Request $request)
    {
        if (@helper::checkaddons('store_review')) {
            $getstorereviewdata = Ratting::find($request->id);
            return view('admin.store_review.edit', compact('getstorereviewdata'));
        } else {
            abort(404);
        }
    }
    public function update(Request $request)
    {
        $store_review = Ratting::find($request->id);
        if ($request->file('image') != "") {
            if (file_exists(env('ASSETSPATHURL') . 'admin-assets/images/reviews/' . $store_review->image)) {
                unlink(env('ASSETSPATHURL') . 'admin-assets/images/reviews/' . $store_review->image);
            }
            $image = 'store_review-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(env('ASSETSPATHURL') . 'admin-assets/images/reviews', $image);
            $store_review->image = $image;
            $store_review->save();
        }
        $store_review->name = $request->name;
        $store_review->ratting = $request->ratting;
        $store_review->comment = $request->comment;
        $store_review->save();
        return redirect('admin/store-review')->with('success', trans('messages.success'));
    }
    public function destroy(Request $request)
    {
        $store_review = Ratting::where('id', $request->id)->first();
        if (file_exists(env('ASSETSPATHURL') . 'admin-assets/images/reviews/' . $store_review->image)) {
            unlink(env('ASSETSPATHURL') . 'admin-assets/images/reviews/' . $store_review->image);
        }
        $store_review->delete();
        if ($store_review) {
            return 1;
        } else {
            return 0;
        }
    }
    public function reorder_ratting(Request $request)
    {
        $getratting = Ratting::all();
        foreach ($getratting as $ratting) {
            foreach ($request->order as $order) {
                $ratting = Ratting::where('id', $order['id'])->first();
                $ratting->reorder_id = $order['position'];
                $ratting->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => 'Update Successfully!!'], 200);
    }
}
