<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Item;
use App\Helpers\helper;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use Session;

class CartController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user() && Auth::user()->type == 2) {
            $getcartlist = Cart::where('user_id', Auth::user()->id)->where('buynow', 0)->orderByDesc('id')->get();
        } else {
            $getcartlist = Cart::where('session_id', Session::getId())->where('buynow', 0)->orderByDesc('id')->get();
        }

        $getsettings = Settings::first();
        $itemtaxes = [];
        $producttax = 0;
        $tax_name = [];
        $tax_price = [];


        foreach ($getcartlist as $cart) {
            $taxlist =  helper::gettax($cart->tax);
            if (!empty($taxlist)) {
                foreach ($taxlist as $tax) {
                    if (!empty($tax)) {
                        if (!in_array($tax->name, $tax_name)) {
                            $tax_name[] = $tax->name;

                            if ($tax->type == 1) {
                                $price = $tax->tax * $cart->qty;
                            }

                            if ($tax->type == 2) {
                                $price = ($tax->tax / 100) * ($cart->addons_total_price + $cart->item_price) * $cart->qty;
                            }
                            $tax_price[] = $price;
                        } else {
                            if ($tax->type == 1) {
                                $price = $tax->tax * $cart->qty;
                            }

                            if ($tax->type == 2) {
                                $price = ($tax->tax / 100) * ($cart->addons_total_price + $cart->item_price) * $cart->qty;
                            }
                            $tax_price[array_search($tax->name, $tax_name)] += $price;
                        }
                    }
                }
            }
        }

        $taxArr['tax'] = $tax_name;
        $taxArr['rate'] = $tax_price;
        return view('web.cart.cart', compact('getcartlist', 'getsettings', 'taxArr'));
    }
    public function addtocart(Request $request)
    {
        try {
            if ($request->buynow == 1) {
                if (Auth::user() && Auth::user()->type == 2) {
                    Cart::where('buynow', 1)->where('user_id', Auth::user()->id)->delete();
                } else {
                    Cart::where('buynow', 1)->where('session_id', Session::getId())->delete();
                }
            }
            $itemdata = Item::where('slug', $request->slug)->first();
            $cart = new Cart();
            if (Auth::user()) {
                $cart->user_id = Auth::user()->id;
                $cart->session_id = "";
            } else {
                $cart->user_id = "";
                $cart->session_id = Session::getId();
            }

            $cart->item_id = $itemdata->id;
            $cart->item_name = $request->item_name;
            $cart->item_type = $request->item_type;
            $cart->item_image = $request->image_name;
            $cart->tax = $request->tax;
            $cart->item_price = helper::number_format($request->item_price);
            $cart->addons_id = $request->addons_id == null ? null : $request->addons_id;
            $cart->addons_name = $request->addons_name == null ? null : $request->addons_name;
            $cart->addons_price = $request->addons_price == null ? null : $request->addons_price;
            $cart->addons_total_price = helper::number_format($request->addons_price == "" ? 0 : array_sum(explode('| ', $request->addons_price)));
            $cart->extras_id = $request->extras_id == null ? null : $request->extras_id;
            $cart->extras_name = $request->extras_name == null ? null : $request->extras_name;
            $cart->extras_price = $request->extras_price == null ? null : $request->extras_price;
            $cart->extras_total_price = helper::number_format($request->extras_price == "" ? 0 : array_sum(explode('| ', $request->extras_price)));
            $cart->qty = $request->qty;
            $cart->buynow = $request->buynow;
            $cart->save();

            if (Auth::user()) {
                $total_count = Cart::where('user_id', Auth::user()->id)->where('buynow', 0)->count();
            } else {
                $oldsessionid = Session::getId();
                Session::put('oldsessionid', $oldsessionid);
                $total_count = Cart::where('session_id', Session::getId())->where('buynow', 0)->count();
            }
            session()->forget('discount_data');
            return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $total_count, 'total_item_count' => helper::get_item_cart($itemdata->id), 'buynow' => $request->buynow], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong'), 'buynow' => $request->buynow], 200);
        }
    }
    public function deletecartitem(Request $request)
    {
        $checkcart = Cart::find($request->id);
        if (!empty($checkcart)) {
            $checkcart->delete();
            session()->forget('discount_data');
            return 1;
        } else {
            return 0;
        }
    }
    public function qtyupdate(Request $request)
    {
        $checkcart = Cart::find($request->id);
        if (Auth::user()) {
            $total_count = Cart::where('user_id', Auth::user()->id)->sum('qty');
        } else {
            $total_count = Cart::where('session_id', Session::getId())->sum('qty');
        }

        if (!empty($checkcart)) {
            try {
                if ($checkcart->qty == 1 && $request->type == "minus") {
                    $checkcart->delete();
                    session()->forget('discount_data');
                } else {
                    if ($request->type == "plus") {
                        if ($total_count < helper::appdata()->max_order_qty) {
                            $checkcart->qty += 1;
                            session()->forget('discount_data');
                        } else {
                            $msg = trans('messages.order_qty_less_then') . ' : ' . helper::appdata()->max_order_qty;
                            return response()->json(['status' => 2, 'message' => $msg], 200);
                        }
                    }
                    if ($request->type == "minus") {
                        $checkcart->qty -= 1;
                        session()->forget('discount_data');
                    }
                    $checkcart->save();
                }
                return response()->json(['status' => 1, 'message' => trans('messages.success')]);
            } catch (\Throwable $th) {
                return response()->json(['status' => 0, 'message' => trans('messages.wrong')]);
            }
            return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.invalid_cart')], 200);
        }
    }
}
