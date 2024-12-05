<?php

namespace App\Http\Controllers\addons;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\helper;
use App\Models\Promocode;

class PromocodeController extends Controller
{
    public function index()
    {
        $getpromocode = Promocode::orderBy('reorder_id')->get();
        return view('admin.promocode.promocode', compact('getpromocode'));
    }
    public function add()
    {
        return view('admin.promocode.add');
    }
    public function store(Request $request)
    {
        $getpromocode = Promocode::where('offer_code', $request->offer_code)->get();
        if ($getpromocode->count() > 0) {
            return redirect('admin/promocode/add')->with('error', trans('messages.coupon_already_exist'));
        } else {
            $promocode = new Promocode;
            $promocode->offer_name = $request->offer_name;
            $promocode->offer_code = $request->offer_code;
            $promocode->offer_type = $request->offer_type;
            $promocode->offer_amount = helper::number_format($request->offer_amount);
            $promocode->min_amount = helper::number_format($request->min_amount);
            $promocode->start_date = $request->start_date;
            $promocode->expire_date = $request->expire_date;
            $promocode->usage_type = $request->usage_type;
            $promocode->usage_limit = $request->usage_type == 1 ? $request->usage_limit : '';
            $promocode->description = $request->description;
            $promocode->is_available = '1';
            $promocode->save();
            return redirect('admin/promocode')->with('success', trans('messages.success'));
        }
    }
    public function show(Request $request)
    {
        $getpromocode = Promocode::find($request->id);
        return view('admin.promocode.edit', compact('getpromocode'));
    }
    public function update(Request $request)
    {
        $promocode = Promocode::find($request->id);
        $promocode->offer_name = $request->offer_name;
        $promocode->offer_code = $request->offer_code;
        $promocode->offer_type = $request->offer_type;
        $promocode->offer_amount = helper::number_format($request->offer_amount);
        $promocode->min_amount = helper::number_format($request->min_amount);
        $promocode->start_date = $request->start_date;
        $promocode->expire_date = $request->expire_date;
        $promocode->usage_type = $request->usage_type;
        $promocode->usage_limit = $request->usage_type == 1 ? $request->usage_limit : '';
        $promocode->description = $request->description;
        $promocode->save();
        return redirect('admin/promocode')->with('success', trans('messages.success'));
    }
    public function status(Request $request)
    {
        $promocode = Promocode::where('id', $request->id)->update(['is_available' => $request->status]);
        if ($promocode) {
            return 1;
        } else {
            return 0;
        }
    }
    public function destroy(Request $request)
    {
        $delete = Promocode::where('id', $request->id)->delete();
        if ($delete) {
            return 1;
        } else {
            return 0;
        }
    }
    public function reorder_promocode(Request $request)
    {
        $getpromocode = Promocode::all();
        foreach ($getpromocode as $promocode) {
            foreach ($request->order as $order) {
                $promocode = Promocode::where('id', $order['id'])->first();
                $promocode->reorder_id = $order['position'];
                $promocode->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => 'Update Successfully!!'], 200);
    }
}
