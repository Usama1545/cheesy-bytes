<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Payment;
use App\Models\State;
use Illuminate\Http\Request;
use App\Models\Shippingarea;
use Illuminate\Support\Str;

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
        $state = null;

        if($request->state)
        {
            $state = State::firstOrCreate(
                ['name' => strtoupper($request->state)]
            );
        }
        $slug = Str::slug($request->name);

        $branch = new Branch();
        $branch->name = $request->name;
        $branch->city = $request->city ?? null;
        $branch->state_id = $state ? $state->id : null;
        $branch->slug = $slug;
        $branch->mac_id = $request->mac_id;
        $branch->zip = $request->zip;
        $branch->address = $request->address;
        $branch->printer_id = $request->printer_id;
        $branch->seo_name = $request->seo_name;
        $branch->webhook_secret = $request->webhook_secret;
        $branch->save();

        $payment = Payment::create([
            'branch_id' => $branch->id,
            'public_key' => $request->public_key,
            'secret_key' => $request->secret_key,
            'unique_identifier' => 'stripe',
            'environment' => 1,
            'payment_type' => 15,
            'image' => 'stripe.png',
            'currency' => 'USD',
            'is_available' => 1,
            'reorder_id' => 4,
            'is_activate' => 1,
        ]);
        return redirect('/admin/branches')->with('success', trans('messages.success'));
    }
    public function update(Request $request)
    {
        $state = null;

        if($request->state)
        {
            $state = State::firstOrCreate(
                ['name' => strtoupper($request->state)]
            );
        }
        $slug = Str::slug($request->name);

        $branch = Branch::find($request->id);
        $branch->name = $request->name;
        $branch->city = $request->city ?? null;
        $branch->state_id = $state ? $state->id : null;
        $branch->slug = $slug;
        $branch->zip = $request->zip;
        $branch->address = $request->address;
        $branch->mac_id = $request->mac_id;
        $branch->printer_id = $request->printer_id;
        $branch->seo_name = $request->seo_name;
        $branch->webhook_secret = $request->webhook_secret;
        $branch->save();

        $branch->paymentMethod()->update([
            'public_key' => $request->public_key,
            'secret_key' => $request->secret_key,
        ]);
        return redirect('/admin/branches')->with('success', trans('messages.success'));
    }

    public function Edit(Request $request)
    {
        $branch = Branch::with('paymentMethod')->find($request->id);
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

     public function status(Request $request)
    {
        $checksbanner = Branch::where('id', $request->id)->update(['is_available' => $request->status]);
        if ($checksbanner) {
            return 1;
        } else {
            return 0;
        }
    }

     public function isMobile(Request $request)
    {
        $checksbanner = Branch::where('id', $request->id)->update(['is_mobile' => $request->status]);
        if ($checksbanner) {
            return 1;
        } else {
            return 0;
        }
    }

     public function isWeb(Request $request)
    {

        $checksbanner = Branch::where('id', $request->id)->update(['is_web' => $request->status]);
        if ($checksbanner) {
            return 1;
        } else {
            return 0;
        }
    }


}
