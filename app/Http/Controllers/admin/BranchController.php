<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\Shippingarea;

class BranchController extends Controller
{
    public function index()
    {
        $getitem = Branch::orderBy('id')->get();
        return view('admin.branches.index', compact('getitem'));
    }
    public function add()
    {
        return view('admin.branches.add');
    }
    public function store(Request $request)
    {
        $branch = new Branch();
        $branch->name = $request->name;
        $branch->city = $request->city;
        $branch->state = $request->state;
        $branch->zip = $request->zip;
        $branch->address = $request->address;
        $branch->save();
        return redirect('/admin/branches')->with('success', trans('messages.success'));
    }
    public function update(Request $request)
    {
        $branch = Branch::find($request->id);
        $branch->name = $request->name;
        $branch->city = $request->city;
        $branch->state = $request->state;
        $branch->zip = $request->zip;
        $branch->address = $request->address;
        $branch->save();
        return redirect('/admin/branches')->with('success', trans('messages.success'));
    }

    public function Edit(Request $request)
    {
        $branch = Branch::find($request->id);
        return view('admin.branches.edit', compact('branch'));
    }

    public function delete(Request $request)
    {
        $delete = Branch::where('id', $request->id)->delete();
        if ($delete) {
            return 1;
        } else {
            return 0;
        }
    }


}
