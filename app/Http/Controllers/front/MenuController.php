<?php

namespace App\Http\Controllers\front;

use App\Helpers\helper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CountySeo;
use App\Models\CustomPizzaCrust;
use App\Models\CustomPizzaSauce;
use App\Models\CustomPizzaTopping;
use App\Models\Subcategory;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpWord\IOFactory;

class MenuController extends Controller
{
    public function index($category)
    {
        $user_id = @Auth::user()->id;
        $session_id = Session::getId();
        $topdeals = helper::top_deals();

        $categorydata = Category::where('slug', $category)->where('is_available', 1)->where('is_deleted', 2)->first();
        $subcategories = Subcategory::where('cat_id', @$categorydata->id)->where('is_available', 1)->where('is_deleted', 2)->get();

        $branchId = Session::get('branch_id');

        if ($user_id != null) {
            $getitemlist = Item::with('category_info', 'subcategory_info', 'item_image', 'prices')
                ->select(
                    'item.*',
                    DB::raw('MAX(CASE WHEN favorite.item_id IS NULL THEN 0 ELSE 1 END) AS is_favorite'),
                    DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"),
                    DB::raw('MAX(CASE WHEN cart.item_id IS NULL THEN 0 ELSE 1 END) AS is_cart')
                )
                ->leftJoin('favorite', function ($query) use ($user_id) {
                    $query->on('favorite.item_id', '=', 'item.id')
                        ->where('favorite.user_id', '=', $user_id);
                })
                ->leftJoin('item_prices', function ($query) use ($branchId) {
                    $query->on('item_prices.item_id', '=', 'item.id')
                        ->where('item_prices.branch_id', '=', $branchId);
                })
                ->leftJoin('cart', function ($query) use ($user_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.user_id', '=', $user_id)
                        ->where('cart.buynow', '=', '0');
                })
                ->where('item.item_status', '1')
                ->where(function($query) {
                    $branchId = Session::get('branch_id');
                    $query->where('item.branch_ids', 'like', "%,$branchId,%") // Match middle
                    ->orWhere('item.branch_ids', 'like', "$branchId,%") // Match start
                    ->orWhere('item.branch_ids', 'like', "%,$branchId") // Match end
                    ->orWhere('item.branch_ids', '=', $branchId);
                })
                ->where('item.cat_id', @$categorydata->id)
                ->groupBy('item.id') // Ensure proper grouping
                ->orderBy('item.reorder_id')->get();
        } else {
            $getitemlist = Item::with('category_info', 'subcategory_info', 'item_image')
                ->select('item.*',
                    DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"),
                    DB::raw('MAX(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                ->leftJoin('cart', function ($query) use ($session_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.session_id', '=', $session_id)
                        ->where('cart.buynow', '=', '0');
                })
                ->leftJoin('item_prices', function ($query) use ($branchId) {
                    $query->on('item_prices.item_id', '=', 'item.id')
                        ->where('item_prices.branch_id', '=', $branchId);
                })
                ->where('item.item_status', '1')
                ->where('item.cat_id', @$categorydata->id)
                ->groupBy('item.id') // Ensure proper grouping
                ->where(function($query) {
                    $branchId = Session::get('branch_id');
                    $query->where('item.branch_ids', 'like', "%,$branchId,%") // Match middle
                    ->orWhere('item.branch_ids', 'like', "$branchId,%") // Match start
                    ->orWhere('item.branch_ids', 'like', "%,$branchId") // Match end
                    ->orWhere('item.branch_ids', '=', $branchId);
                })
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
        $htmlContent = CountySeo::where('county', $country)->where('category', $category)->pluck('content')->first();

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
                ->where(function($query) {
                    $branchId = Session::get('branch_id');
                    $query->where('item.branch_ids', 'like', "%,$branchId,%") // Match middle
                    ->orWhere('item.branch_ids', 'like', "$branchId,%") // Match start
                    ->orWhere('item.branch_ids', 'like', "%,$branchId") // Match end
                    ->orWhere('item.branch_ids', '=', $branchId);
                })
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
                ->where(function($query) {
                    $branchId = Session::get('branch_id');
                    $query->where('item.branch_ids', 'like', "%,$branchId,%") // Match middle
                    ->orWhere('item.branch_ids', 'like', "$branchId,%") // Match start
                    ->orWhere('item.branch_ids', 'like', "%,$branchId") // Match end
                    ->orWhere('item.branch_ids', '=', $branchId);
                })
                ->groupBy('item.id') // Ensure proper grouping
                ->orderBy('item.reorder_id')
                ->get();
        }
        $getitemlist = $getitemlist->groupBy(function ($item) {
            return $item->subcategory_info->subcategory_name ?? $item->category_info->category_name;
        });

        return view('web.menu', compact('topdeals', 'categorydata', 'subcategories', 'getitemlist','country','htmlContent'));
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

    function fixFormatting($html)
    {
        // Normalize line breaks and whitespace issues
        $html = preg_replace('/\s+/', ' ', $html);

        // Fix broken words by looking for unnecessary line breaks or spaces
        $html = preg_replace('/(\w+)\s*\n\s*(\w+)/', '$1 $2', $html);

        // Replace colons followed by line breaks with proper spacing
        $html = preg_replace('/:\s*\n\s*/', ': ', $html);

        // Ensure proper paragraph formatting if needed
        $html = preg_replace('/<p>(.*?)<\/p>/', '<p>$1</p>', $html);

        return $html;
    }
}
