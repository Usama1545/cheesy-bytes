<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GlobalExtras;
use Illuminate\Support\Facades\Auth;

class GlobalExtrasController extends Controller
{
    public function index()
    {
        $globals =  GlobalExtras::orderBy('reorder_id')->get();
        return view('admin.global_extras.global_extras', compact('globals'));
    }
    public function add()
    {
        return view('admin.global_extras.add');
    }
    public function store(Request $request)
    {
        $store = new GlobalExtras();
        $store->branch_id = Auth::user()->id;
        $store->name = $request->name;
        $store->price = $request->price;
        $store->save();
        return redirect('admin/global_extras')->with('success', trans('messages.success'));
    }
    public function edit(Request $request)
    {
        $editextras = GlobalExtras::where('id', $request->id)->first();
        return view('admin.global_extras.edit', compact('editextras'));
    }
    public function update(Request $request)
    {
        $editextras = GlobalExtras::where('id', $request->id)->first();
        $editextras->name = $request->name;
        $editextras->price = $request->price;
        $editextras->save();
        return redirect('admin/global_extras')->with('success', trans('messages.success'));
    }
    public function delete(Request $request)
    {
        $delete = GlobalExtras::where('id', $request->id)->first();
        $delete->delete();
        if ($delete) {
            return 1;
        } else {
            return 0;
        }
    }
    public function change_status(Request $request)
    {
        $globalextras = GlobalExtras::where('id', $request->id)->update(['is_available' => $request->status]);
        if ($globalextras) {
            return 1;
        } else {
            return 0;
        }
    }

    public function reorder_global(Request $request)
    {
        $global = GlobalExtras::all();
        foreach ($global as $works) {
            foreach ($request->order as $order) {
                $works = GlobalExtras::where('id', $order['id'])->first();
                $works->reorder_id = $order['position'];
                $works->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
}
