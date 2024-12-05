<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    public function index()
    {
        $getdriverlist = User::where('type', '3')->orderByDesc('id')->paginate(12);
        return view('admin.driver.driver', compact('getdriverlist'));
    }
    public function add()
    {
        return view('admin.driver.add');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email,NULL,id,is_deleted,2,type,3',
            'mobile' => 'required|unique:users,mobile,NULL,id,is_deleted,2,type,3',
        ], [
            "email.required" => trans('messages.email_required'),
            "email.unique" => trans('messages.email_exist'),
            "mobile.required" => trans('messages.mobile_required'),
            "mobile.unique" => trans('messages.mobile_exist'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $image = 'identity-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(env('ASSETSPATHURL') . 'admin-assets/images/profile', $image);

            $driver = new User;
            $driver->name = $request->name;
            $driver->email = $request->email;
            $driver->mobile = $request->mobile;
            $driver->profile_image = $image;
            $driver->identity_image = $image;
            $driver->identity_type = $request->identity_type;
            $driver->identity_number = $request->identity_number;
            $driver->password = Hash::make($request->password);
            $driver->type = "3";
            $driver->save();
            return redirect('admin/driver')->with('success', trans('messages.success'));
        }
    }
    public function show(Request $request)
    {
        $getdriverdata = User::find($request->id);
        return view('admin.driver.edit', compact('getdriverdata'));
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email,' . $request->id . ',id,is_deleted,2,type,3',
            'mobile' => 'required|unique:users,mobile,' . $request->id . ',id,is_deleted,2,type,3',
        ], [
            "email.required" => trans('messages.email_required'),
            "email.unique" => trans('messages.email_exist'),
            "mobile.required" => trans('messages.mobile_required'),
            "mobile.unique" => trans('messages.mobile_exist'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $driver = User::find($request->id);
            if ($request->file('image') != "") {
                if (file_exists(env('ASSETSPATHURL') . 'admin-assets/images/profile/' . $driver->identity_image)) {
                    unlink(env('ASSETSPATHURL') . 'admin-assets/images/profile/' . $driver->identity_image);
                }
                $image = 'identity-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(env('ASSETSPATHURL') . 'admin-assets/images/profile', $image);
                $driver->identity_image = $image;
                $driver->save();
            }
            $driver->name = $request->name;
            $driver->email = $request->email;
            $driver->mobile = $request->mobile;
            $driver->identity_type = $request->identity_type;
            $driver->identity_number = $request->identity_number;
            $driver->save();
            return redirect('admin/driver')->with('success', trans('messages.success'));
        }
    }
    public function status(Request $request)
    {
        $users = User::where('id', $request->id)->update(array('is_available' => $request->status));
        if ($users) {
            return 1;
        } else {
            return 0;
        }
    }
    public function driverdetails(Request $request)
    {
        $getdriverdata = User::where('id', $request->id)->first();
        $getorders = Order::with('user_info', 'driver_info')->where('driver_id', $request->id)->get();

        $totalprocessing = Order::whereIn('status_type', array(1, 2))->where('driver_id', $request->id)->count();
        $totalcompleted = Order::where('status_type', 3)->where('driver_id', $request->id)->count();

        return view('admin.driver.driverdetails', compact('getdriverdata', 'getorders', 'totalprocessing', 'totalcompleted'));
    }
}
