<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\helper;
use App\Models\User;
use App\Models\Roles;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $getusers = User::where('type', '2')->where('is_deleted', 2)->orderBydesc('id')->get();
        return view('admin.users.users', compact('getusers'));
    }
    public function add_customers()
    {
        return view('admin.users.add');
    }
    public function store_customers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email,NULL,id,is_deleted,2,type,2',
            'mobile' => 'required|unique:users,mobile,NULL,id,is_deleted,2,type,2',
        ], [
            "email.required" => trans('messages.email_required'),
            "email.unique" => trans('messages.email_exist'),
            "mobile.required" => trans('messages.mobile_required'),
            "mobile.unique" => trans('messages.mobile_exist'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $customers = new User;
            $customers->name = $request->name;
            $customers->email = $request->email;
            $customers->mobile = $request->mobile;
            $customers->password = Hash::make($request->password);
            $customers->profile_image = 'unknown.png';
            $customers->referral_code = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'), 0, 10);
            $customers->login_type = "email";
            $customers->type = 2;
            $customers->is_available = 1;
            $customers->is_verified = 1;
            $customers->save();
            return redirect('admin/users')->with('success', trans('messages.success'));
        }
    }
    public function userdetails(Request $request)
    {
        $getusers = User::where('id', $request->id)->first();
        $getorders = Order::with('user_info', 'driver_info')->select('order.*', 'users.name')->leftJoin('users', 'order.driver_id', '=', 'users.id')->where('order.user_id', $request->id)->get();
        $getdriver = User::where('type', '3')->where('is_available', 1)->orderByDesc('id')->get();
        $gettransactions = Transaction::select('id', 'user_id', 'order_id', 'order_number', 'amount', 'transaction_id', 'transaction_type', 'username', 'created_at')->where('user_id', $request->id)->orderByDesc('id')->get();
        return view('admin.users.user-details', compact('getusers', 'getorders', 'getdriver', 'gettransactions'));
    }
    public function show_customers(Request $request)
    {
        $customersdata = User::find($request->id);
        return view('admin.users.update', compact('customersdata'));
    }
    public function update_customers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,' . $request->id . ',id,is_deleted,2,type,2',
            'mobile' => 'required|unique:users,mobile,' . $request->id . ',id,is_deleted,2,type,2',
        ], [
            "email.required" => trans('messages.email_required'),
            "email.email" => trans('messages.invalid_email'),
            "email.unique" => trans('messages.email_exist'),
            "mobile.required" => trans('messages.mobile_required'),
            "mobile.unique" => trans('messages.mobile_exist'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $customersdata = User::find($request->id);
            $customersdata->name = $request->name;
            $customersdata->email = $request->email;
            $customersdata->mobile = $request->mobile;
            $customersdata->save();
            return redirect('admin/users')->with('success', trans('messages.success'));
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
    public function delete(Request $request)
    {
        $users = User::where('id', $request->id)->update(array('is_deleted' => 1));
        if ($users) {
            return 1;
        } else {
            return 0;
        }
    }
    public function add_deduct(Request $request)
    {
        try {
            $checkuser = User::find($request->id);
            $title = "";
            $body = "";
            if ($request->type == 'add') {
                $checkuser->wallet = $checkuser->wallet + $request->money;
                $checkuser->save();
                $Wallet = new Transaction;
                $Wallet->user_id = $request->id;
                $Wallet->amount = $request->money;
                $Wallet->transaction_type = 102;
                $Wallet->save();
                $title = trans('labels.wallet_recharge');
                $body = "Amount " . helper::currency_format($request->money) . " has been credited to your wallet by Admin.";
            }
            if ($request->type == 'deduct') {
                if ($checkuser->wallet < $request->money) {
                    return response()->json(['success' => 0, 'errors' => array("amount" => trans('messages.amount_less_then') . ' : ' . helper::currency_format($checkuser->wallet))], 200);
                } else {
                    $checkuser->wallet = $checkuser->wallet - $request->money;
                    $checkuser->save();
                    $Wallet = new Transaction;
                    $Wallet->user_id = $request->id;
                    $Wallet->amount = $request->money;
                    $Wallet->transaction_type = 103;
                    $Wallet->save();
                }
                $title = trans('labels.wallet_deduction');
                $body = "Amount " . helper::currency_format($request->money) . " has been debited from your wallet by Admin.";
            }
            $noti = helper::push_notification($checkuser->token, $title, $body, "wallet", "");
            return response()->json(['success' => 1, 'message' => trans('messages.success'), 'wallet' => helper::currency_format($checkuser->wallet)], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    // -------------------- Employee ----------------------
    public function employee(Request $request)
    {
        $getemployee = User::with('role_info')->where('type', 4)->orderByDesc('id')->paginate(12);
        return view('admin.employee.index', compact('getemployee'));
    }
    public function add_employee(Request $request)
    {
        $getroles = Roles::where('is_available', 1)->orderByDesc('id')->get();
        return view('admin.employee.add', compact('getroles'));
    }
    public function store_employee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|unique:users,mobile',
            'password' => 'required',
            'role' => 'required',
        ], [
            "name.required" => trans('messages.name_required'),
            "email.required" => trans('messages.email_required'),
            "email.email" => trans('messages.invalid_email'),
            "email.unique" => trans('messages.email_exist'),
            "mobile.required" => trans('messages.mobile_required'),
            "mobile.unique" => trans('messages.mobile_exist'),
            "password.required" => trans('messages.password_required'),
            "role.required" => trans('messages.role_selection_required'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $employee = new User;
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->mobile = $request->mobile;
            $employee->password = Hash::make($request->password);
            $employee->profile_image = 'unknown.png';
            $employee->role_id = $request->role;
            $employee->type = 4;
            $employee->save();
            return redirect('admin/employee')->with('success', trans('messages.success'));
        }
    }
    public function show_employee(Request $request)
    {
        $getroles = Roles::where('is_available', 1)->orderByDesc('id')->get();
        $employeedata = User::find($request->id);
        return view('admin.employee.update', compact('getroles', 'employeedata'));
    }
    public function update_employee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'mobile' => 'required|unique:users,mobile,' . $request->id,
            'role' => 'required',
        ], [
            "name.required" => trans('messages.name_required'),
            "email.required" => trans('messages.email_required'),
            "email.email" => trans('messages.invalid_email'),
            "email.unique" => trans('messages.email_exist'),
            "mobile.required" => trans('messages.mobile_required'),
            "mobile.unique" => trans('messages.mobile_exist'),
            "role.required" => trans('messages.role_selection_required'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $employeedata = User::find($request->id);
            $employeedata->name = $request->name;
            $employeedata->email = $request->email;
            $employeedata->mobile = $request->mobile;
            $employeedata->role_id = $request->role;
            $employeedata->save();
            return redirect('admin/employee')->with('success', trans('messages.success'));
        }
    }
    public function status_employee(Request $request)
    {
        $users = User::where('id', $request->id)->update(array('is_available' => $request->status));
        if ($users) {
            return 1;
        } else {
            return 0;
        }
    }
}
