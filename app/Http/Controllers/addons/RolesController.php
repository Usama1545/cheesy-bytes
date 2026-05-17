<?php

namespace App\Http\Controllers\addons;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Roles;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    public function index(Request $request)
    {
        $getroles = Roles::orderBydesc('id')->get();
        return view('admin.roles.index', compact('getroles'));
    }
    public function add()
    {
        return view('admin.roles.add');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'modules' => 'required',
        ], [
            "modules.required" => trans('messages.one_selection_required'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            foreach ($request->modules as $key => $value) {
                $titles[] = $request->title[$value];
            }
            $role = new Roles;
            $role->name = $request->name;
            $role->modules = implode(',', $request->modules);
            $role->titles = implode(',', $titles);
            $role->is_available = 1;
            $role->save();
            return redirect('admin/roles')->with('success', trans('messages.success'));
        }
    }
    public function show(Request $request, $id)
    {
        $data = Roles::find($id);
        return view('admin.roles.edit', compact('data'));
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'modules' => 'required',
        ], [
            "modules.required" => trans('messages.one_selection_required'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            foreach ($request->modules as $value) {
                $titles[] = $request->title[$value];
            }
            $role = Roles::find($id);
            $role->name = $request->name;
            $role->modules = implode(',', $request->modules);
            $role->titles = implode(',', $titles);
            $role->save();
            return redirect('admin/roles')->with('success', trans('messages.success'));
        }
    }
    public function status(Request $request)
    {
        $role = Roles::where('id', $request->id)->update(['is_available' => $request->status]);
        if ($role) {
            return 1;
        } else {
            return 0;
        }
    }
}
