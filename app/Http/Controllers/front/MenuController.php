<?php

namespace App\Http\Controllers\front;

use App\Helpers\helper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CustomPizzaCrust;
use App\Models\CustomPizzaSauce;
use App\Models\CustomPizzaTopping;
use App\Models\Subcategory;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
{
    public function index($category)
    {
        $user_id = @Auth::user()->id;
        $session_id = Session::getId();
        $topdeals = helper::top_deals();

        $categorydata = Category::where('slug', $category)->where('is_available', 1)->where('is_deleted', 2)->first();
        $subcategories = Subcategory::where('cat_id', @$categorydata->id)->where('is_available', 1)->where('is_deleted', 2)->get();


        if ($user_id != null) {
            $getitemlist = Item::with('category_info', 'subcategory_info', 'item_image')
                ->select('item.*',
                    DB::raw('MAX(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),
                    DB::raw('MAX(case when item.price is null then 0 else item.price end) as item_price'),
                    DB::raw('MAX(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                ->leftJoin('favorite', function ($query) use ($user_id) {
                    $query->on('favorite.item_id', '=', 'item.id')
                        ->where('favorite.user_id', '=', $user_id);
                })
                ->leftJoin('cart', function ($query) use ($user_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.user_id', '=', $user_id)
                        ->where('cart.buynow', '=', '0');
                })
                ->where('item.item_status', '1')
                ->where('item.cat_id', @$categorydata->id)
                ->groupBy('item.id') // Ensure proper grouping
                ->orderBy('item.reorder_id')->get();
        } else {
            $getitemlist = Item::with('category_info', 'subcategory_info', 'item_image')
                ->select('item.*',
                    DB::raw('MAX(case when item.price is null then 0 else item.price end) as item_price'),
                    DB::raw('MAX(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                ->leftJoin('cart', function ($query) use ($session_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.session_id', '=', $session_id)
                        ->where('cart.buynow', '=', '0');
                })
                ->where('item.item_status', '1')
                ->where('item.cat_id', @$categorydata->id)
                ->groupBy('item.id') // Ensure proper grouping
                ->orderBy('item.reorder_id')
                ->get();
        }
        $getitemlist = $getitemlist->groupBy(function ($item) {
            return $item->subcategory_info->subcategory_name ?? $item->category_info->category_name;
        });

        return view('web.menu', compact('topdeals', 'categorydata', 'subcategories', 'getitemlist'));
    }

    public function index_con($country,$category)
    {
        $user_id = @Auth::user()->id;
        $session_id = Session::getId();
        $topdeals = helper::top_deals();

        $categorydata = Category::where('slug', $category)->where('is_available', 1)->where('is_deleted', 2)->first();
        $subcategories = Subcategory::where('cat_id', @$categorydata->id)->where('is_available', 1)->where('is_deleted', 2)->get();


        if ($user_id != null) {
            $getitemlist = Item::with('category_info', 'subcategory_info', 'item_image')
                ->select('item.*',
                    DB::raw('MAX(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),
                    DB::raw('MAX(case when item.price is null then 0 else item.price end) as item_price'),
                    DB::raw('MAX(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                ->leftJoin('favorite', function ($query) use ($user_id) {
                    $query->on('favorite.item_id', '=', 'item.id')
                        ->where('favorite.user_id', '=', $user_id);
                })
                ->leftJoin('cart', function ($query) use ($user_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.user_id', '=', $user_id)
                        ->where('cart.buynow', '=', '0');
                })
                ->where('item.item_status', '1')
                ->where('item.cat_id', @$categorydata->id)
                ->groupBy('item.id') // Ensure proper grouping
                ->orderBy('item.reorder_id')->get();
        } else {
            $getitemlist = Item::with('category_info', 'subcategory_info', 'item_image')
                ->select('item.*',
                    DB::raw('MAX(case when item.price is null then 0 else item.price end) as item_price'),
                    DB::raw('MAX(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                ->leftJoin('cart', function ($query) use ($session_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.session_id', '=', $session_id)
                        ->where('cart.buynow', '=', '0');
                })
                ->where('item.item_status', '1')
                ->where('item.cat_id', @$categorydata->id)
                ->groupBy('item.id') // Ensure proper grouping
                ->orderBy('item.reorder_id')
                ->get();
        }
        $getitemlist = $getitemlist->groupBy(function ($item) {
            return $item->subcategory_info->subcategory_name ?? $item->category_info->category_name;
        });

        return view('web.menu', compact('topdeals', 'categorydata', 'subcategories', 'getitemlist','country'));
    }

    public function getCrusts()
    {
        $crusts = CustomPizzaCrust::all()->map(function ($crust) {
            return [
                'id' => $crust->id,
                'name' => $crust->name,
                'price' => $crust->price,
                'description' => $crust->description,
                'size_id' => $crust->size_id,
            ];
        });

        return response()->json($crusts);
    }

    public function getToppings()
    {
        $toppings = CustomPizzaTopping::all()->map(function ($topping) {
            return [
                'id' => $topping->id,
                'name' => $topping->name,
                'price' => $topping->price,
                'size_id' => $topping->size_id,
            ];
        });

        return response()->json($toppings);
    }

    public function getSauces()
    {
        $sauces = CustomPizzaSauce::all()->map(function ($sauce) {
            return [
                'id' => $sauce->id,
                'name' => $sauce->name,
                'price' => $sauce->price,
                'size_id' => $sauce->size_id,
            ];
        });

        return response()->json($sauces);
    }
}
