<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Session;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        session()->put('previous_url', url()->previous());
        $getaddresses = Address::select('id', 'user_id', 'address_type', 'address', 'landmark', 'postal_code', 'is_default', 'title')->where('user_id', Auth::user()->id)->orderbyDesc('id')->paginate(10);
        return view('web.address.index', compact('getaddresses'));
    }
    public function add(Request $request)
    {
        session()->put('previous_url', url()->previous());
        session()->put('last_url', url()->previous());
        return view('web.address.add');
    }
    public function store(Request $request)
    {
        try {
            $checkdefault = Address::where('is_default',1)->where('user_id',Auth::user()->id)->first();
            if(!empty($checkdefault))
            {
                $checkdefault->is_default = 2;
                $checkdefault->update();
            }
            $newaddress = new Address();
            $newaddress->user_id = @Auth::user()->id;
            $newaddress->address = $request->address;
            $newaddress->title = $request->title;
            $newaddress->landmark = $request->landmark;
            $newaddress->postal_code = $request->pincode;
            $newaddress->country = $request->country;
            $newaddress->city = $request->city;
            $newaddress->state = $request->state;
            if($request->is_default == null)
            {
                $newaddress->is_default = 2;
            }else{
                $newaddress->is_default = $request->is_default;
            }           
            $newaddress->save();
            return redirect(session()->get('previous_url'))->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
    public function show(Request $request)
    {
        session()->put('previous_url', url()->previous());
        if (Auth::user()) {
            $addressdata = Address::find($request->id);
        } else {
            $addressdata = Session::get('addressdata');
        }
        if (!empty($addressdata)) {
            return view('web.address.update', compact('addressdata'));
        }
        return redirect()->back()->with('error', trans('messages.wrong'));
    }


    public function update(Request $request)
    {
        try {

            $checkdefault = Address::where('is_default', 1)->where('id', '!=', $request->id)->where('user_id', Auth::user()->id)->first();
            if (!empty($checkdefault)) {
                $checkdefault->is_default = 2;
                $checkdefault->update();
            }
            $checkaddress = Address::find($request->id);
            $checkaddress->address = $request->address;
            $checkaddress->title = $request->title;
            $checkaddress->landmark = $request->landmark;
            $checkaddress->postal_code = $request->pincode;
            $checkaddress->country = $request->country;
            $checkaddress->city = $request->city;
            $checkaddress->state = $request->state;
            if ($request->is_default == null) {
                $checkaddress->is_default = 2;
            } else {
                $checkaddress->is_default = $request->is_default;
            }
            $checkaddress->update();
            return redirect(session()->get('previous_url'))->with('success', trans('messages.success'));
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
    public function deleteaddress(Request $request)
    {
        if (Auth::user()) {
            $checkaddress = Address::find($request->id);
            if (!empty($checkaddress)) {
                $checkaddress->delete();
                return 1;
            } else {
                return 0;
            }
        } else {
            session()->forget('addressdata');
            return 1;
        }
    }

    public function address_status(Request $request)
    {
        try {
            $findaddress = Address::where('is_default', 1)->where('user_id', Auth::user()->id)->first();
            if ($findaddress != null) {
                $findaddress->is_default = 2;
                $findaddress->update();
            }
            Address::where('id', $request->id)->update(array('is_default' => $request->status));
            return 1;
        } catch (\Throwable $th) {

            return 0;
        }
    }

    public function getaddress(Request $request)
    {
        $addressdata = Address::where('id', $request->id)->where('user_id', Auth::user()->id)->first();
        return response()->json(['status' => 1, 'data' => $addressdata], 200);
    }
}
