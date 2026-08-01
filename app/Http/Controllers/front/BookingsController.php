<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blogs;
use App\Models\Bookings;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Item;
use App\Models\Languages;
use App\Models\Ratting;
use App\Models\Settings;
use App\Models\Slider;
use App\Models\Team;
use App\Models\TopDeals;
use App\Models\User;
use App\Helpers\helper;
use App\Models\WhyChooseUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class BookingsController extends Controller
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
        $sliders = Slider::with('item_info', 'category_info')->where('is_available', 1)->orderByDesc('id')->get();
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
                    DB::raw("MAX(CASE WHEN item_prices.branch_id = $branchId THEN COALESCE(item_prices.price, 0) ELSE 0 END) AS item_price"),
                    DB::raw('(case when cart.item_id is null then 0 else 1 end) as is_cart'))
                ->leftJoin('cart', function ($query) use ($user_id) {
                    $query->on('cart.item_id', '=', 'item.id')
                        ->where('cart.user_id', '=', $user_id)
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

        }
        $setting = Settings::first();
        $theme = $setting->theme;
        if (env('Environment') == 'sendbox') {
            if ($request->theme_id) {
                $theme = $request->theme_id;
            }
        }

        $lang = Languages::get();
        return view('web.catering' . '.index', compact('sliders', 'banners', 'todayspecial', 'topitemlist', 'getblogs', 'getwhychooseus', 'topdeals', 'getgalleries', 'lang'));
    }

    public function store(Request $request)
    {

        try {
            $booking_number = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", 10)), 0, 10);

            $date = $request->date;
            $time = helper::time_format($request->time);
            // to - Admin

            $booking = new Bookings();
            $booking->booking_number = $booking_number;
            $booking->date = $date;
            $booking->time = $time;
            $booking->guests = $request->guests;
            $booking->reservation_type = $request->reservation_type;
            $booking->name = $request->name;
            $booking->email = $request->email;
            $booking->mobile = $request->mobile;
            $booking->special_request = $request->special_request;
            $booking->branch_id = Session::get('branch_id');
            $booking->status = 1;
            $booking->save();
            return redirect()->back()->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
}
