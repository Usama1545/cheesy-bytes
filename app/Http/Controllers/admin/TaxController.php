<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Support\Facades\Validator;

class TaxController extends Controller
{
    public function index()
    {
        $gettax = Tax::orderBy('reorder_id')->get();
        return view('admin.tax.tax', compact('gettax'));
    }
    public function add()
    {
        return view('admin.tax.add');
    }
    public function store(Request $request)
    {
        $tax = new Tax();
        $tax->name = $request->name;
        $tax->type = $request->type;
        $tax->tax = $request->tax;
        $tax->save();
        return redirect('admin/tax')->with('success', trans('messages.success'));
    }
    public function show(Request $request)
    {
        $taxdata = Tax::findorFail($request->id);
        return view('admin.tax.edit', compact('taxdata'));
    }
    public function update(Request $request)
    {
        $tax = Tax::find($request->id);
        $tax->name = $request->name;
        $tax->type = $request->type;
        $tax->tax = $request->tax;
        $tax->save();
        return redirect('admin/tax')->with('success', trans('messages.success'));
    }
    public function delete(Request $request)
    {
        $tax = Tax::where('id', $request->id)->delete();
        if ($tax) {
            return 1;
        } else {
            return 0;
        }
    }
    public function status(Request $request)
    {
        $tax = Tax::where('id', $request->id)->update(array('is_available' => $request->status));
        if ($tax) {
            return 1;
        } else {
            return 0;
        }
    }
    public function reorder_tax(Request $request)
    {
        $gettax = Tax::all();
        foreach ($gettax as $tax) {
            foreach ($request->order as $order) {
                $tax = Tax::where('id', $order['id'])->first();
                $tax->reorder_id = $order['position'];
                $tax->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => 'Update Successfully!!'], 200);
    }
}
