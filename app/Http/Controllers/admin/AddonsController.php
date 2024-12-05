<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\helper;
use App\Models\Addons;
use App\Models\AddonsGroup;
use App\Models\Cart;

class AddonsController extends Controller
{
    public function index()
    {
        $getaddons = Addons::where('is_deleted', '2')->orderBy('reorder_id')->get();
        return view('admin.addons.addons', compact('getaddons'));
    }
    public function add()
    {
        $getaddongroup = AddonsGroup::where('is_deleted', 2)->orderBy('reorder_id')->get();
        return view('admin.addons.add', compact('getaddongroup'));
    }
    public function store(Request $request)
    {
        $addons = new Addons();
        $addons->addongroup_id = $request->addongroup_id;
        $addons->name = $request->name;
        $addons->price = helper::number_format($request->type == 1 ? 0 : $request->price);
        $addons->save();
        return redirect('admin/addongroup-' . $request->addongroup_id)->with('success', trans('messages.success'));
    }
    public function show(Request $request)
    {
        $addonsdata = Addons::findorFail($request->id);
        $getaddongroup = AddonsGroup::where('is_deleted', 2)->orderBy('reorder_id')->get();
        return view('admin.addons.edit', compact('addonsdata', 'getaddongroup'));
    }
    public function update(Request $request)
    {
        $addons = Addons::find($request->id);
        $addons->addongroup_id = $request->addongroup_id;
        $addons->name = $request->name;
        $addons->price = helper::number_format($request->type == 1 ? 0 : $request->price);
        $addons->save();
        return redirect('admin/addongroup-' . $request->addongroup_id)->with('success', trans('messages.success'));
    }
    public function destroy(Request $request)
    {
        $addons = Addons::where('id', $request->id)->delete();
        if ($addons) {
            return 1;
        } else {
            return 0;
        }
    }
    public function status(Request $request)
    {
        $category = Addons::where('id', $request->id)->update(array('is_available' => $request->status));
        if ($category) {
            Cart::where('addons_id', 'LIKE', '%' . $request->id . '%')->delete();
            return 1;
        } else {
            return 0;
        }
    }
    public function delete(Request $request)
    {
        $UpdateDetails = Addons::where('id', $request->id)->update(['is_deleted' => '1']);
        if ($UpdateDetails) {
            Cart::where('addons_id', 'LIKE', '%' . $request->id . '%')->delete();
            return 1;
        } else {
            return 0;
        }
    }
    public function reorder_addons(Request $request)
    {
        $getaddons = Addons::all();
        foreach ($getaddons as $addons) {
            foreach ($request->order as $order) {
                $addons = Addons::where('id', $order['id'])->first();
                $addons->reorder_id = $order['position'];
                $addons->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => 'Update Successfully!!'], 200);
    }

    //Addons Group
    public function addons_group_index(Request $request)
    {
        $getaddongroup = AddonsGroup::where('is_deleted', 2)->orderBy('reorder_id')->get();
        return view('admin.addons-group.addons_group', compact('getaddongroup'));
    }
    public function add_addons_group()
    {
        return view('admin.addons-group.add');
    }
    public function store_addons_group(Request $request)
    {
        $addongroup = new AddonsGroup();
        $addongroup->name = $request->name;
        $addongroup->selection_type = $request->selection_type;
        $addongroup->selection_count = $request->selection_count;
        $addongroup->min_count = $request->selection_count == 1 ? 1 : $request->min_count;
        $addongroup->max_count = $request->selection_count == 1 ? 1 : $request->max_count;
        $addongroup->save();
        return redirect('admin/addongroup')->with('success', trans('messages.success'));
    }
    public function show_addons_group(Request $request)
    {
        $addongroupdata = AddonsGroup::findorFail($request->id);
        $getaddons = Addons::where('addongroup_id', $request->id)->where('is_deleted', 2)->orderBy('reorder_id')->get();
        return view('admin.addons-group.edit', compact('addongroupdata', 'getaddons'));
    }
    public function update_addons_group(Request $request)
    {
        $addongroup = AddonsGroup::find($request->id);
        $addongroup->name = $request->name;
        $addongroup->selection_type = $request->selection_type;
        $addongroup->selection_count = $request->selection_count;
        $addongroup->min_count = $request->selection_count == 1 ? 1 : $request->min_count;
        $addongroup->max_count = $request->selection_count == 1 ? 1 : $request->max_count;
        $addongroup->save();
        return redirect('admin/addongroup')->with('success', trans('messages.success'));
    }
    public function status_addons_group(Request $request)
    {
        $addongroup = AddonsGroup::where('id', $request->id)->update(array('is_available' => $request->status));
        if ($addongroup) {
            Cart::where('addons_id', 'LIKE', '%' . $request->id . '%')->delete();
            return 1;
        } else {
            return 0;
        }
    }
    public function delete_addons_group(Request $request)
    {
        $addongroup = AddonsGroup::where('id', $request->id)->update(['is_deleted' => '1']);
        if ($addongroup) {
            Cart::where('addons_id', 'LIKE', '%' . $request->id . '%')->delete();
            return 1;
        } else {
            return 0;
        }
    }
    public function reorder_addongroup(Request $request)
    {
        $getaddongroup = AddonsGroup::all();
        foreach ($getaddongroup as $addongroup) {
            foreach ($request->order as $order) {
                $addongroup = AddonsGroup::where('id', $order['id'])->first();
                $addongroup->reorder_id = $order['position'];
                $addongroup->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => 'Update Successfully!!'], 200);
    }
}
