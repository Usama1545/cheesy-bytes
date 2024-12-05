<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TermsCondition;
use Illuminate\Support\Facades\Validator;

class TermsController extends Controller
{
    public function index(){
        $gettermscondition = TermsCondition::where('id','1')->first();
        return view('admin.cms.termscondition',compact('gettermscondition'));
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),
        ['termscondition' => 'required'],
        ["termscondition.required"=>trans('messages.termscondition_required')]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $termscondition = TermsCondition::first();
            if(empty($termscondition)){
                $termscondition = new TermsCondition();
            }
            $termscondition->termscondition_content = $request->termscondition;
            $termscondition->save();
            return redirect('admin/termscondition')->with('success', trans('messages.success'));
        }
    }




    public function termscondition(){
        $gettermscondition = TermsCondition::where('id','1')->first();
        return view('cms.terms-condition',compact('gettermscondition'));
    }
}
