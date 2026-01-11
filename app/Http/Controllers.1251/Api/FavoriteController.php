<?php

namespace App\Http\Controllers\Api;

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
        $user_id = auth()->id();
        

        $favorites = Item::with(['category_info', 'subcategory_info', 'item_image'])
            ->select(
                'item.*',
                'favorite.id as favorite_id',
                DB::raw('CASE WHEN favorite.item_id IS NULL THEN 0 ELSE 1 END AS is_favorite'),
                DB::raw('COALESCE(item.price, 0) as item_price'),
                DB::raw('CASE WHEN cart.item_id IS NULL THEN 0 ELSE 1 END AS is_cart')
            )
            ->join('favorite', function ($q) use ($user_id) {
                $q->on('favorite.item_id', '=', 'item.id')
                  ->where('favorite.user_id', $user_id);
            })
            ->leftJoin('cart', function ($q) use ($user_id) {
                $q->on('cart.item_id', '=', 'item.id')
                  ->where('cart.user_id', $user_id)
                  ->where('cart.buynow', 0);
            })
            ->where('item.item_status', 1)
            ->where('favorite.user_id', $user_id)
            ->groupBy('item.id', 'cart.item_id', 'favorite.item_id')
            ->orderByDesc('favorite.id')
            ->get();

        return response()->json([
            'status' => true,
            'favorites' => $favorites
        ]);
    }


    public function toggle(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:item,id',
        ]);     

        $user_id = auth()->id();

        $existing = Favorite::where('user_id', $user_id)
                            ->where('item_id', $request->item_id)
                            ->first();

        if ($existing) {
            $existing->delete();

            return response()->json([
                'status' => true,
                'message' => 'Removed from favorites',
                'is_favorite' => false
            ]);
        }

        Favorite::create([
            'user_id' => $user_id,
            'item_id' => $request->item_id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Added to favorites',
            'is_favorite' => true
        ]);
    }
}

