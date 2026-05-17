<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Item;
use App\Helpers\helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $topdeals = helper::top_deals();
        $user_id = @Auth::user()->id;
        $getfavoritelist = Item::with('category_info', 'subcategory_info', 'item_image')->select('item.*', 'favorite.id as favorite_id', DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'), DB::raw('(case when item.price is null then 0 else item.price end) as item_price'), DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
            ->join('favorite', function ($query) use ($user_id) {
                $query->on('favorite.item_id', '=', 'item.id')
                    ->where('favorite.user_id', '=', $user_id);
            })
            ->leftJoin('cart', function ($query) use ($user_id) {
                $query->on('cart.item_id', '=', 'item.id')
                    ->where('cart.user_id', '=', $user_id)
                    ->where('cart.buynow', '=', '0');
            })
            ->groupBy('item.id', 'cart.item_id', 'favorite.item_id')
            ->where('item.item_status', '1')
            ->where('favorite.user_id', $user_id)
            ->orderByDesc('favorite.id')->paginate(9);
        return view('web.favoritelist', compact('topdeals', 'getfavoritelist'));
    }
    public function managefavorite(Request $request)
    {
        $data = '';
        $checkfavorite = Favorite::where('user_id', Auth::user()->id)->where('item_id', $request->id)->first();
        try {
            if ($request->type == 1) {
                $favorite = new Favorite();
                $favorite->user_id = Auth::user()->id;
                $favorite->item_id = $request->id;
                $favorite->save();

                $data = '<a class="text-dark fw-600 d-flex gap-1 py-2 align-items-center" href="javascript:void(0)" onclick="managefavorite(' . $request->id . ',0,' . chr(0x27) . $request->favurl . chr(0x27) . ')"> <i class="fa-solid fa-heart fs-6"></i>' . trans('labels.remove_wishlist') . '</a>';
            }
            if ($request->type == 0) {
                $checkfavorite->delete();

                $data = '<a class="text-dark fw-600 d-flex gap-1 py-2 align-items-center" href="javascript:void(0)" onclick="managefavorite(' . $request->id . ',1,' . chr(0x27) . $request->favurl . chr(0x27) . ')"> <i class="fa-regular fa-heart fs-6"></i>' . trans('labels.add_wishlist') . '</a>';
            }
            return response()->json(['status' => 1, 'message' => trans('messages.success'), "data" => $data], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong'), "data" => $data], 200);
        }
    }
}
