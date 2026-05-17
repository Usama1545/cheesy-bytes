<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $getpayment = Payment::where('is_activate', '1')->orderBy('reorder_id')->get();
        return view('admin.payment.payment', compact('getpayment'));
    }

    public function update(Request $request)
    {
        $pay_data = Payment::where('payment_type', $request->payment_id)->first();

        $pay_data->is_available = $request->is_available != null ? $request->is_available[$pay_data->payment_type] : '2';
        $pay_data->payment_name = $request->name;

        if (

            $request->payment_id == 3 ||
            $request->payment_id == 4 ||
            $request->payment_id == 5 ||
            $request->payment_id == 6 ||
            $request->payment_id == 7 ||
            $request->payment_id == 8 ||
            $request->payment_id == 9 ||
            $request->payment_id == 10 || $request->payment_id == 11 || $request->payment_id == 12 || $request->payment_id == 13 || $request->payment_id == 14
        ) {
            $pay_data->environment = $request->environment[$pay_data->payment_type];
            $pay_data->public_key = $request->public_key[$pay_data->payment_type];
            $pay_data->secret_key = $request->secret_key[$pay_data->payment_type];
            $pay_data->currency = $request->currency[$pay_data->payment_type];
            if ($request->payment_id == 5) {
                $pay_data->encryption_key = $request->encryption_key;
            }
            if ($request->payment_id == 11) {
                $pay_data->base_url_by_region = $request->base_url_by_region;
            }
        }
        if ($request->has('image')) {
            if ($pay_data->image != strtolower($pay_data->payment_name) . ".png" && file_exists(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $pay_data->image)) {
                unlink(env('ASSETSPATHURL') . 'admin-assets/images/about/' . $pay_data->image);
            }
            $image = 'payment-' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(env('ASSETSPATHURL') . 'admin-assets/images/about/', $image);
            $pay_data->image = $image;
        }
        $pay_data->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }

    public function reorder_payment(Request $request)
    {
        if ($request->has('ids')) {
            $arr = explode(',', $request->input('ids'));
            foreach ($arr as $sortOrder => $id) {
                $menu = Payment::find($id);
                $menu->reorder_id = $sortOrder;
                $menu->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
}
