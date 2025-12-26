<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TagScript;
use Illuminate\Http\Request;

class ScriptController extends Controller
{
    public function index()
    {
        $getitem = TagScript::orderBy('id')->get();
        return view('admin.scripts.index', compact('getitem'));
    }
    
    public function add()
    {
        return view('admin.scripts.add');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'script' => 'required',
            'branch_id' => 'required|exists:branches,id',
        ]);
        
        
        TagScript::create([
            'type' => $request->name,
            'script' => $request->script,
            'branch_id' => $request->branch_id,
        ]);

        return redirect('/admin/scripts')->with('success', trans('messages.success'));
    }
    
    public function edit(Request $request)
    {
        $script = TagScript::find($request->id);
        return view('admin.scripts.edit', compact('script'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'script' => 'required',
            'branch_id' => 'required|exists:branches,id',
        ]);
        
        $branch = TagScript::find($id);
        $branch->update([
            'type' => $request->name,
            'script' => $request->script,
            'branch_id' => $request->branch_id,
        ]);

        return redirect('/admin/scripts')->with('success', trans('messages.success'));
    }

    public function delete($id)
    {
        $delete = TagScript::find($id)->delete();
        if ($delete) {
            return 1;
        } else {
            return 0;
        }
    }
}