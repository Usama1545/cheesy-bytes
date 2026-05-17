<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Aboutus;
use Illuminate\Http\Request;
use App\Models\TermsCondition;
use App\Models\PrivacyPolicy;
use App\Models\RefundPolicy;
use Illuminate\Support\Facades\Validator;

class CMSPagesController extends Controller
{
    // -----------------------------------------------------------------
    // -------------------  Privacy-Policy  ----------------------------
    // -----------------------------------------------------------------
    public function privacypolicy()
    {
        $getprivacypolicy = PrivacyPolicy::where('id', '1')->first();
        return view('admin.cms.privacypolicy', compact('getprivacypolicy'));
    }
    public function privacypolicy_update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ['privacypolicy' => 'required'],
            ["privacypolicy.required" => trans('messages.content_required')]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $privacypolicy = PrivacyPolicy::first();
            if (empty($privacypolicy)) {
                $privacypolicy = new PrivacyPolicy();
            }
            $privacypolicy->privacypolicy_content = $request->privacypolicy;
            $privacypolicy->save();
            return redirect('admin/privacypolicy')->with('success', trans('messages.success'));
        }
    }
    // -----------------------------------------------------------------
    // ------------------- Terms-Condition -----------------------------
    // -----------------------------------------------------------------
    public function termscondition()
    {
        $gettermscondition = TermsCondition::where('id', '1')->first();
        return view('admin.cms.termscondition', compact('gettermscondition'));
    }
    public function termscondition_update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ['termscondition' => 'required'],
            ["termscondition.required" => trans('messages.content_required')]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $termscondition = TermsCondition::first();
            if (empty($termscondition)) {
                $termscondition = new TermsCondition();
            }
            $termscondition->termscondition_content = $request->termscondition;
            $termscondition->save();
            return redirect('admin/termscondition')->with('success', trans('messages.success'));
        }
    }
    // -----------------------------------------------------------------
    // -------------------- Refund-Policy ------------------------------
    // -----------------------------------------------------------------
    public function refundpolicy()
    {
        $getrefundpolicy = RefundPolicy::first();
        return view('admin.cms.refundpolicy', compact('getrefundpolicy'));
    }
    public function refundpolicy_update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ['refundpolicy' => 'required'],
            ["refundpolicy.required" => trans('messages.content_required')]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $refundpolicy = RefundPolicy::first();
            if (empty($refundpolicy)) {
                $refundpolicy = new RefundPolicy();
            }
            $refundpolicy->refundpolicy_content = $request->refundpolicy;
            $refundpolicy->save();
            return redirect('admin/refundpolicy')->with('success', trans('messages.success'));
        }
    }
    // -----------------------------------------------------------------
    // -------------------- About-us ------------------------------
    // -----------------------------------------------------------------
    public function aboutus()
    {
        $aboutdata = Aboutus::first();
        return view('admin.cms.aboutus', compact('aboutdata'));
    }
    public function aboutus_update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ['about_content' => 'required'],
            ["about_content.required" => trans('messages.content_required')]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $about = Aboutus::first();
            if (empty($about)) {
                $about = new Aboutus();
            }
            $about->about_content = $request->about_content;
            $about->save();
        }

        return redirect('admin/aboutus')->with('success', trans('messages.success'));
    }
}
