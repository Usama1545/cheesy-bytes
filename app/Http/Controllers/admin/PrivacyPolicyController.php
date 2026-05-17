<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;
use Illuminate\Support\Facades\Validator;

class PrivacyPolicyController extends Controller
{
    public function index(){
        $getprivacypolicy = PrivacyPolicy::where('id','1')->first();
        return view('admin.cms.privacypolicy',compact('getprivacypolicy'));
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),
        ['privacypolicy' => 'required'],
        ["privacypolicy.required"=>trans('messages.privacypolicy_required')]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $privacypolicy = PrivacyPolicy::first();
            if(empty($privacypolicy)){
                $privacypolicy = new PrivacyPolicy();
            }
            $privacypolicy->privacypolicy_content = $request->privacypolicy;
            $privacypolicy->save();
            return redirect('admin/privacypolicy')->with('success', trans('messages.success'));
        }
    }
}
