<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shippingarea;

class ShippingareaController extends Controller
{
    public function index()
    {
        $shippingarealist = Shippingarea::orderBy('reorder_id')->get();
        return view('admin.shippingarea.index', compact('shippingarealist'));
    }
    public function add()
    {
        return view('admin.shippingarea.add');
    }
    public function store(Request $request)
    {
        $shippingarea = new Shippingarea();
        $shippingarea->name = $request->name;
        $shippingarea->delivery_charge = $request->delivery_charge;
        $shippingarea->save();
        return redirect('/admin/shippingarea')->with('success', trans('messages.success'));
    }
    public function update(Request $request)
    {
        $shippingarea = Shippingarea::find($request->id);
        $shippingarea->name = $request->name;
        $shippingarea->delivery_charge = $request->delivery_charge;
        $shippingarea->save();
        return redirect('/admin/shippingarea')->with('success', trans('messages.success'));
    }

    public function Edit(Request $request)
    {
        $shippingareadata = Shippingarea::find($request->id);
        return view('admin.shippingarea.edit', compact('shippingareadata'));
    }

    public function delete(Request $request)
    {
        $delete = Shippingarea::where('id', $request->id)->delete();
        if ($delete) {
            return 1;
        } else {
            return 0;
        }
    }

    public function reorder_shippingarea(Request $request)
    {
        $shippingarea = Shippingarea::get();
        foreach ($shippingarea as $works) {
            foreach ($request->order as $order) {
                $works = Shippingarea::where('id', $order['id'])->first();
                $works->reorder_id = $order['position'];
                $works->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
}
