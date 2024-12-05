<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\helper;
use App\Models\Promocode;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;

class PromocodeController extends Controller
{
    public function checkpromocode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'offer_code' => 'required',
        ], [
            "offer_code.required" => trans('messages.offercode_required'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $checkoffercode = Promocode::where('promocode.offer_code', $request->offer_code)->where('is_available', 1)->first();
            if (!empty($checkoffercode)) {
                if ((date('Y-m-d') >= $checkoffercode->start_date) && (date('Y-m-d') <= $checkoffercode->expire_date)) {
                    if ($request->order_amount >= $checkoffercode->min_amount) {
                        $checkcount = Order::select('offer_code')->where('offer_code', $request->offer_code)->count();
                        if ($checkoffercode->usage_type == 1) {
                            if ($checkcount < $checkoffercode->usage_limit) {
                                if ($checkoffercode->offer_type == 1) {
                                    $offer_amount = $checkoffercode->offer_amount;
                                } else {
                                    $offer_amount = $request->order_amount * $checkoffercode->offer_amount / 100;
                                }
                                $arr = array(
                                    "offer_code" => $checkoffercode->offer_code,
                                    "offer_amount" => $offer_amount,
                                );
                                session()->put('discount_data', $arr);
                                return redirect()->back()->with('success', trans('messages.success'));
                            } else {
                                return redirect()->back()->with('error', trans('messages.once_per_user'))->withInput();
                            }
                        } else {
                            // if($checkcount < $checkoffercode->per_user){
                            if ($checkoffercode->offer_type == 1) {
                                $offer_amount = $checkoffercode->offer_amount;
                            } else {
                                $offer_amount = $request->order_amount * $checkoffercode->offer_amount / 100;
                            }
                            $arr = array(
                                "offer_code" => $checkoffercode->offer_code,
                                "offer_amount" => $offer_amount,
                            );
                            session()->put('discount_data', $arr);
                            return redirect()->back()->with('success', trans('messages.success'));
                            // }else{
                            //     return redirect()->back()->with('error',trans('messages.usage_limit_exceeded'))->withInput();
                            // }
                        }
                    } else {
                        return redirect()->back()->with('error', trans('messages.order_amount_greater_then') . ' : ' . helper::currency_format($checkoffercode->min_amount))->withInput();
                    }
                } else {
                    return redirect()->back()->with('error', trans('messages.offer_expired'))->withInput();
                }
            } else {
                return redirect()->back()->with('error', trans('messages.invalid_promocode'))->withInput();
            }
        }
    }
    public function removepromocode()
    {
        session()->forget('discount_data');
        return redirect()->back()->with('success', trans('messages.success'));
    }
}
