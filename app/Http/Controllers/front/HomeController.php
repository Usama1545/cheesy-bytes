<?php

namespace App\Http\Controllers\front;

use App\helpers\helper;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Cart;
use App\Models\CustomerAddress;
use App\Models\Carrier;
use App\Models\Shippingarea;
use App\Models\Slider;
use App\Models\Item;
use App\Models\Banner;
use App\Models\Blogs;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Ratting;
use App\Models\Languages;
use App\Models\Settings;
use App\Models\State;
use App\Models\Team;
use App\Models\TopDeals;
use App\Models\WhyChooseUs;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
                $branchId = Session::get('branch_id');
        $currentDateTime = now(); // Get the current date and time
        $topdeals = helper::top_deals();
        $offer_price = 0;
        if ($topdeals != null && $topdeals->offer_type == 1) {
            $offer_price = (int)$topdeals->offer_amount;
        }
        $getgalleries = Gallery::select('image', DB::raw("CONCAT('" . url(env('ASSETSPATHURL') . 'admin-assets/images/about') . "/', image) AS image_url"))->orderByDesc('id')->get();
        $user_id = @Auth::user()->id;
        $session_id = Session::getId();
        $sliders = Slider::with('item_info', 'category_info')->where('is_available', 1)->where('branch_id', $branchId)->orderByDesc('id')->get();
        $bannerlist = Banner::with('item_info', 'category_info')->where('is_available', 1)->where('branch_id', $branchId)->orderBy('reorder_id')->get();
        $banners = array();
        $banners['topbanners'] = array();
        $banners['bannersection1'] = array();
        $banners['bannersection2'] = array();
        $banners['bannersection3'] = array();
        foreach ($bannerlist as $bannerdata) {
            if ($bannerdata->section == 1) {
                $banners['topbanners'][] = array(
                    "id" => $bannerdata->id,
                    "item_id" => $bannerdata->item_id,
                    "cat_id" => $bannerdata->cat_id,
                    "image" => helper::image_path($bannerdata->image),
                    "item_info" => $bannerdata->item_info,
                    "category_info" => $bannerdata->category_info,
                );
            }
            if ($bannerdata->section == 2) {
                $banners['bannersection1'][] = array(
                    "id" => $bannerdata->id,
                    "item_id" => $bannerdata->item_id,
                    "cat_id" => $bannerdata->cat_id,
                    "image" => helper::image_path($bannerdata->image),
                    "item_info" => $bannerdata->item_info,
                    "category_info" => $bannerdata->category_info,
                );
            }
            if ($bannerdata->section == 3) {
                $banners['bannersection2'][] = array(
                    "id" => $bannerdata->id,
                    "item_id" => $bannerdata->item_id,
                    "cat_id" => $bannerdata->cat_id,
                    "image" => helper::image_path($bannerdata->image),
                    "item_info" => $bannerdata->item_info,
                    "category_info" => $bannerdata->category_info,
                );
            }
            if ($bannerdata->section == 4) {
                $banners['bannersection3'][] = array(
                    "id" => $bannerdata->id,
                    "item_id" => $bannerdata->item_id,
                    "cat_id" => $bannerdata->cat_id,
                    "image" => helper::image_path($bannerdata->image),
                    "item_info" => $bannerdata->item_info,
                    "category_info" => $bannerdata->category_info,
                );
            }
        }
        $storereviews = Ratting::where('user_id', '1')->orderBy('reorder_id')->get();
        $getteams = Team::select("id", "name", "designation", "fb", "youtube", "insta", "twitter", "description", "image")->orderBy('reorder_id')->take('6')->get();
        $getfaqs = Faq::select("id", "title", "description")->orderBy('reorder_id')->get();
        $getblogs = Blogs::orderBy('reorder_id')->take('3')->get();
        $getwhychooseus = WhyChooseUs::orderBy('reorder_id')->get();

        if ($user_id != null) {
            $topitemlist = Item::with('category_info', 'subcategory_info', 'item_image')
                ->select('item.*', 'order_details.qty as order_details_qty',
                    DB::raw('count(order_details.item_id) as item_order_counter'),
                    DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),
                    DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"),
                    DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                ->leftJoin('order_details', 'order_details.item_id', 'item.id')
                ->leftJoin('item_prices', function ($query) use ($branchId) {
                    $query->on('item_prices.item_id', '=', 'item.id')
                        ->where('item_prices.branch_id', '=', $branchId);
                })
                ->leftJoin('favorite', function ($query) use ($user_id) {
                    $query->on('favorite.item_id', '=', 'item.id')
                        ->where('favorite.user_id', '=', $user_id);
                })
                ->leftJoin('cart', function ($query) use ($user_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.user_id', '=', $user_id)
                        ->where('cart.buynow', '=', '0');
                })
                ->groupBy('order_details.item_id', 'item.id', 'cart.item_id')
                ->orderByDesc('item_order_counter')
                ->where(function ($query) {
                    $branchId = Session::get('branch_id');
                    $query->where('item.branch_ids', 'like', "%,$branchId,%") // Match middle
                    ->orWhere('item.branch_ids', 'like', "$branchId,%") // Match start
                    ->orWhere('item.branch_ids', 'like', "%,$branchId") // Match end
                    ->orWhere('item.branch_ids', '=', $branchId);
                })
                ->where('item.item_status', '1')
                ->take(3)->get();

            $todayspecial = Item::with('category_info', 'subcategory_info', 'item_image')
                ->select('item.*',
                    DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),
                    DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"),
                    DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
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
                ->groupBy('item.id', 'cart.item_id')
                ->where('item.is_featured', '1')
                ->where(function ($query) {
                    $branchId = Session::get('branch_id');
                    $query->where('item.branch_ids', 'like', "%,$branchId,%") // Match middle
                    ->orWhere('item.branch_ids', 'like', "$branchId,%") // Match start
                    ->orWhere('item.branch_ids', 'like', "%,$branchId") // Match end
                    ->orWhere('item.branch_ids', '=', $branchId);
                })
                ->where('item.item_status', '1')
                ->orderBy('item.reorder_id')->take(8)->get();

//            $topdealsproduct = Item::with('category_info', 'subcategory_info', 'item_image')->select('item.*', DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'), DB::raw('(case when item.price is null then 0 else item.price end) as item_price'), DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
//                ->leftJoin('favorite', function ($query) use ($user_id) {
//                    $query->on('favorite.item_id', '=', 'item.id')
//                        ->where('favorite.user_id', '=', $user_id);
//                })
//                ->leftJoin('cart', function ($query) use ($user_id) {
//                    $query->on('cart.item_id', '=', 'item.id')
//                        ->where('cart.user_id', '=', $user_id)
//                        ->where('cart.buynow', '=', '0');
//                })
//                ->groupBy('item.id', 'cart.item_id')
//                ->where('item.is_top_deals', '1')
//                ->where('item.item_status', '1')
//                ->where('item.price', '>', $offer_price)
//                ->orderBy('item.reorder_id')->take(8)->get();
            $topdealsproduct = helper::getTopDeals();
            $recommended = Item::with('category_info', 'subcategory_info', 'item_image')
                ->select('item.*',
                    DB::raw('(case when favorite.item_id is null then 0 else 1 end) as is_favorite'),
                    DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"),
                    DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
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
                ->groupBy('item.id', 'cart.item_id')
                ->inRandomOrder()
                ->where(function ($query) {
                    $branchId = Session::get('branch_id');
                    $query->where('item.branch_ids', 'like', "%,$branchId,%") // Match middle
                    ->orWhere('item.branch_ids', 'like', "$branchId,%") // Match start
                    ->orWhere('item.branch_ids', 'like', "%,$branchId") // Match end
                    ->orWhere('item.branch_ids', '=', $branchId);
                })
                ->where('item.item_status', '1')
                ->take(9)->get();
        } else {
            $topitemlist = Item::with('category_info', 'subcategory_info', 'item_image')
                ->select('item.*', 'order_details.qty as order_details_qty',
                    DB::raw('count(order_details.item_id) as item_order_counter'),
                    DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"),

                    DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                ->leftJoin('order_details', 'order_details.item_id', 'item.id')
                ->leftJoin('item_prices', function ($query) use ($branchId) {
                    $query->on('item_prices.item_id', '=', 'item.id')
                        ->where('item_prices.branch_id', '=', $branchId);
                })
                ->leftJoin('cart', function ($query) use ($session_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.session_id', '=', $session_id)
                        ->where('cart.buynow', '=', '0');
                })
                ->groupBy('order_details.item_id', 'item.id', 'cart.item_id')
                ->orderByDesc('item_order_counter')
                ->where('item.item_status', '1')
                ->where(function ($query) {
                    $branchId = Session::get('branch_id');
                    $query->where('item.branch_ids', 'like', "%,$branchId,%") // Match middle
                    ->orWhere('item.branch_ids', 'like', "$branchId,%") // Match start
                    ->orWhere('item.branch_ids', 'like', "%,$branchId") // Match end
                    ->orWhere('item.branch_ids', '=', $branchId);
                })
                ->take(3)->get();

            $todayspecial = Item::with('category_info', 'subcategory_info', 'item_image')
                ->select('item.*',
                    DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"),
                    DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                ->leftJoin('cart', function ($query) use ($session_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.session_id', '=', $session_id)
                        ->where('cart.buynow', '=', '0');
                })
                ->leftJoin('item_prices', function ($query) use ($branchId) {
                    $query->on('item_prices.item_id', '=', 'item.id')
                        ->where('item_prices.branch_id', '=', $branchId);
                })
                ->groupBy('item.id', 'cart.item_id')
                ->where('item.is_featured', '1')
                ->where('item.item_status', '1')
                ->where(function ($query) {
                    $branchId = Session::get('branch_id');
                    $query->where('item.branch_ids', 'like', "%,$branchId,%") // Match middle
                    ->orWhere('item.branch_ids', 'like', "$branchId,%") // Match start
                    ->orWhere('item.branch_ids', 'like', "%,$branchId") // Match end
                    ->orWhere('item.branch_ids', '=', $branchId);
                })
                ->orderBy('item.reorder_id')
                ->take(8)->get();

//            $topdealsproduct = Item::with('category_info', 'subcategory_info', 'item_image')->select('item.*', DB::raw('(case when item.price is null then 0 else item.price end) as item_price'), DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
//                ->leftJoin('cart', function ($query) use ($session_id) {
//                    $query->on('cart.item_id', '=', 'item.id')
//                        ->where('cart.session_id', '=', $session_id)
//                        ->where('cart.buynow', '=', '0');
//                })
//                ->groupBy('item.id', 'cart.item_id')
//                ->where('item.is_top_deals', '1')
//                ->where('item.item_status', '1')
//                ->where('item.price', '>', $offer_price)
//                ->orderBy('item.reorder_id')->take(10)->get();
            $topdealsproduct = helper::getTopDeals();

            $recommended = Item::with('category_info', 'subcategory_info', 'item_image')
                ->select('item.*',
                    DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"),
                    DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                ->leftJoin('cart', function ($query) use ($session_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.session_id', '=', $session_id)
                        ->where('cart.buynow', '=', '0');
                })
                ->leftJoin('item_prices', function ($query) use ($branchId) {
                    $query->on('item_prices.item_id', '=', 'item.id')
                        ->where('item_prices.branch_id', '=', $branchId);
                })
                ->groupBy('item.id', 'cart.item_id')
                ->inRandomOrder()
                ->where('item.item_status', '1')
                ->where(function ($query) {
                    $branchId = Session::get('branch_id');
                    $query->where('item.branch_ids', 'like', "%,$branchId,%") // Match middle
                    ->orWhere('item.branch_ids', 'like', "$branchId,%") // Match start
                    ->orWhere('item.branch_ids', 'like', "%,$branchId") // Match end
                    ->orWhere('item.branch_ids', '=', $branchId);
                })
                ->take(8)->get();
        }

        $setting = Settings::first();
        $theme = $setting->theme;
        if (env('Environment') == 'sendbox') {
            if ($request->theme_id) {
                $theme = $request->theme_id;
            }
        }

        $lang = Languages::get();
        return view('web.home' . $theme . '.index', compact('sliders', 'banners', 'todayspecial', 'topitemlist', 'storereviews', 'getteams', 'getfaqs', 'getblogs', 'getwhychooseus', 'recommended', 'topdealsproduct', 'topdeals', 'getgalleries', 'lang'));
    }

    public function categories(Request $request)
    {
        return view('web.categoryviewall');
    }

    public function categories_con(Request $request, $county)
    {
        return view('web.categoryviewall', compact('county'));
    }

    public function menu(Request $request)
    {
        return view('web.menu');
    }

    public function change_dir(Request $request)
    {
        session()->put('direction', $request->dir);
        return redirect()->back();
    }

    public function location()
    {
        $states = State::orderByDesc('created_at')->get();
        return view('web.restaurant', compact('states'));
    }

   public function location_store(Request $request)
    {
        $response = [];
        if ($request->type === 'carryout') {
           $shipping = Branch::where('is_available',1)->where('is_web', true)->orderBy('created_at','asc')->get();
        } else {
            $shipping = Branch::where('is_available',1)->where('is_web', true)->orderBy('created_at','asc')->get();
        }
        $type = $request->type;
        if($request->type === 'delivery')
        {
            return view('web.deliveryBranch', compact( 'shipping', 'type'));
        }
        return view('web.location', compact('shipping',  'type'));
    }

    public function delivery_providers($id)
    {

            $response = [];

            $shipping = Branch::FindOrFail($id);

            $carriers = Carrier::with('branch')->where('branch_id',$id)->get();

            $groupedCarriers = $carriers->groupBy('branch_id');

            foreach ($groupedCarriers as $branchId => $carriers) {
                $branchName = $carriers->first()->branch->name ?? 'Unknown Branch';
                $response[] = [
                    'name' => $branchName,
                    'carriers' => $carriers->map(function ($carrier) {
                        return [
                            'name' => $carrier->name,
                            'description' => $carrier->description,
                            'image' => $carrier->image,
                            'link' => $carrier->link,
                        ];
                    }),
                ];
            }
            $type="delivery";
            return view('web.delivery', compact( 'response', 'type'));
    }
    
    public function location_update($id)
    {
        $branch = Branch::findOrFail($id);

        if ($branch) {
            $sessionId = Session::getId();

            if (Auth::check()) {
                Cart::where('user_id', auth()->id())->delete();
            } else {
                Cart::where('session_id', $sessionId)->delete();
            }

            Session::forget('branch_id');
            Session::put('branch_id', $id);

            $branchName = $branch->slug;
            return redirect()->to("/{$branchName}/deals");
        }

        return redirect()->to('/location');
    }

    public function rewards()
    {
        return view('web.reward');
    }
}
