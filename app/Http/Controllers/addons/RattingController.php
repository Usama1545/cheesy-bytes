<?php

namespace App\Http\Controllers\addons;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ratting;
use Illuminate\Support\Facades\Auth;
use App\Helpers\helper;

class RattingController extends Controller
{
    public function index()
    {
        $getstorereviewlist = Ratting::orderBy('reorder_id')->paginate(12);
        return view('admin.store_review.store_review', compact('getstorereviewlist'));

    }
    public function add()
    {
        return view('admin.store_review.add');
    }
    public function store(Request $request)
    {
        $image = 'store_review-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(env('ASSETSPATHURL') . 'admin-assets/images/reviews', $image);
        $store_review = new Ratting();
        $store_review->user_id = auth()->user()->id;
        $store_review->name = $request->name;
        $store_review->ratting = $request->ratting;
        $store_review->comment = $request->comment;
        $store_review->image = $image;
        $store_review->save();
        $this->updateProductAverageRating($request->product_id);

        return redirect('admin/store-review')->with('success', trans('messages.success'));
    }

    public function addReview(Request $request)
    {
        $store_review = new Ratting();
        $store_review->user_id = auth()->user()->id;
        $store_review->ratting = $request->ratting;
        $store_review->item_id = $request->item_id;
        $store_review->comment = $request->comment ?? '';
        $store_review->save();
        $this->updateProductAverageRating($request->item_id);

        return redirect()->back()->with('success', trans('messages.success'));
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
        if ($store_review) {
            $store_review->delete();
            $this->updateProductAverageRating($request->item_id);
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

    protected function updateProductAverageRating($productId)
    {
        $averageRating = Ratting::where('item_id', $productId)->avg('ratting');

        $product = Item::find($productId);
        $product->avg_ratting = round($averageRating, 2); // Round to 2 decimal places
        $product->save();
    }
}
