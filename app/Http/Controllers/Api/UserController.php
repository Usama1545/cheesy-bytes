<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\helper;
use App\Helpers\sms_helper;
use App\Models\User;
use App\Models\Cart;
use App\Models\OTPConfiguration;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;

class UserController extends Controller
{
    public function register()
    {
        if (@helper::checkaddons('customer_login')) {
            return response()->json([
                'status' => true,
                'message' => 'Registration endpoint is available'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Customer login feature is not available'
            ], 404);
        }
    }
    
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'mobile'   => 'required|numeric|unique:users,mobile',
            'password' => 'required|min:6',
            'checkbox' => 'accepted'
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'Email already exists',
            'mobile.required' => 'Mobile number is required',
            'mobile.numeric' => 'Mobile number must contain only numbers',
            'mobile.unique' => 'Mobile number already exists',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
            'checkbox.accepted' => 'Please accept the terms and conditions',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
    
        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'mobile'        => $request->mobile,
            'password'      => Hash::make($request->password),
            'profile_image' => 'unknown.png',
            'login_type'    => 'email',  // keep this if needed
            'type'          => 2,
            'is_available'  => 1,
            'is_verified'   => 1,        // set verified directly
            'referral_code' => substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'), 0, 10),
        ]);
    
        Auth::login($user);
    
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                ],
                'token' => $token
            ]
        ]);
    }


    public function verifyotp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required',
        ], [
            'otp.required' => 'OTP is required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        if (@helper::checkaddons('otp')) {
            $mobile = $request->mobile ?? session()->get('verification_email');
            if (!$mobile) {
                return response()->json([
                    'status' => false,
                    'message' => 'Mobile number is required'
                ], 400);
            }
            $checkuser = User::where('mobile', $mobile)->where('type', 2)->first();
        } else {
            $email = $request->email ?? session()->get('verification_email');
            if (!$email) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email is required'
                ], 400);
            }
            $checkuser = User::where('email', $email)->where('is_verified', 2)->first();
        }

        if (empty($checkuser)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid user'
            ], 404);
        }

        $is_valid_otp = 2;
        if (@helper::checkaddons('otp')) {
            $getconfiguration = OTPConfiguration::where('status', 1)->first();
            if ($getconfiguration && $getconfiguration->name == "msg91") {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.msg91.com/api/v5/otp/verify?authkey=" . $getconfiguration->msg_authkey . "&mobile=" . $mobile . "&otp=" . $request->otp . "",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                ));
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                $response = json_decode($response);
                $is_valid_otp = $response->type == "error" ? 2 : 1;
            } else {
                $is_valid_otp = $checkuser->otp != $request->otp ? 2 : 1;
            }
        }

        if ($checkuser->otp == $request->otp || $is_valid_otp == 1) {
                $checkuser->otp = null;
                $checkuser->is_verified = 1;
                $checkuser->save();
                session()->forget('verification_email');
                session()->forget('social_login');
                session()->forget('verification_otp');

                // CHECK_USER_HAS_REFFERAL_USER
                if ($checkuser->user_id > 0) {
                    // ---- for referral user ------
                    $checkreferral = User::find($checkuser->user_id);
                    $checkreferral->wallet += $checkuser->referral_amount;
                    $checkreferral->referral_amount = $checkuser->referral_amount;
                    $checkreferral->save();
                    $referral_tr = new Transaction;
                    $referral_tr->user_id = $checkreferral->id;
                    $referral_tr->amount = $checkuser->referral_amount;
                    $referral_tr->transaction_type = 101;
                    $referral_tr->username = $checkuser->name;
                    $referral_tr->save();
                    // ---- for new user ------
                    $new_user_tr = new Transaction;
                    $new_user_tr->user_id = $checkuser->id;
                    $new_user_tr->amount = $checkuser->referral_amount;
                    $new_user_tr->transaction_type = 101;
                    $new_user_tr->username = $checkreferral->name;
                    $new_user_tr->save();
                    $checkuser->wallet = $checkuser->referral_amount;
                    $checkuser->user_id = "";
                    $checkuser->referral_amount = 0;
                    $checkuser->save();
                    $title = 'Referral Earning';
                    $body = 'Your friend "' . $checkuser->name . '" has used your referral code to register with Our Restaurant. You have earned "' . helper::currency_format(helper::appdata()->referral_amount) . '" referral amount in your wallet.';
                    helper::push_notification($checkreferral->token, $title, $body, "wallet", "");
                    $referralmessage = 'Your friend "' . $checkuser->name . '" has used your referral code to register with Restaurant User. You have earned "' . helper::appdata()->currency . '' . number_format(helper::appdata()->referral_amount, 2) . '" referral amount in your wallet.';
                    $emaildata = helper::emailconfigration();
                    Config::set('mail', $emaildata);
                    helper::referral($checkreferral->email, $checkuser->name, $checkreferral->name, $referralmessage);
                }

                $token = null;
                if (@helper::checkaddons('otp')) {
                    Auth::loginUsingId($checkuser->id, true);
                    // Generate token if Sanctum is available
                    if (method_exists($checkuser, 'createToken')) {
                        $token = $checkuser->createToken('auth_token')->plainTextToken;
                    }
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Success',
                    'data' => [
                        'user' => [
                            'id' => $checkuser->id,
                            'name' => $checkuser->name,
                            'email' => $checkuser->email,
                            'mobile' => $checkuser->mobile,
                            'is_verified' => $checkuser->is_verified
                        ],
                        'token' => $token
                    ]
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid OTP'
                ], 400);
            }
    }
    public function resendotp(Request $request)
    {
        $otp = rand(100000, 999999);

        if (@helper::checkaddons('otp')) {
            $mobile = $request->mobile ?? session()->get('verification_email');
            if (!$mobile) {
                return response()->json([
                    'status' => false,
                    'message' => 'Mobile number is required'
                ], 400);
            }
            $checkuser = User::where('mobile', $mobile)->where('is_deleted', 2)->first();
            $verification = sms_helper::verificationsms($mobile, $otp);
        } else {
            $email = $request->email ?? session()->get('verification_email');
            if (!$email) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email is required'
                ], 400);
            }
            $checkuser = User::where('email', $email)->where('is_deleted', 2)->first();
            $emaildata = helper::emailconfigration();
            Config::set('mail', $emaildata);
            $verification = helper::verificationemail($email, $otp);
        }

        if (empty($checkuser)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid user'
            ], 404);
        }

        if ($verification == 1) {
            $checkuser->otp = $otp;
            $checkuser->is_verified = 2;
            $checkuser->save();
            if (env('Environment') == 'sendbox') {
                session()->put('verification_otp', $otp);
            }
            return response()->json([
                'status' => true,
                'message' => 'Email sent successfully',
                'data' => [
                    'otp' => env('Environment') == 'sendbox' ? $otp : null
                ]
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Email sending failed'
            ], 500);
        }
    }

    public function checklogin(Request $request)
    {
        
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ], [
                'email.required' => 'Email is required',
                'email.email' => 'Please enter a valid email address',
                'password.required' => 'Password is required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            if (Auth::attempt($request->only('email', 'password'))) {
                if (Auth::user()->type == 2) {
                    if (Auth::user()->is_available == 1) {
                       
                            $oldsessionid = $request->header('X-Session-Id') ?? session()->get('oldsessionid');
                            if ($oldsessionid) {
                                Cart::where('session_id', $oldsessionid)->update([
                                    'user_id' => Auth::user()->id,
                                    'session_id' => '',
                                ]);
                            }

                            $token = null;
                            // Generate token if Sanctum is available
                            
                            $token = Auth::user()->createToken('auth_token')->plainTextToken;
                            

                            return response()->json([
                                'status' => true,
                                'message' => 'Success',
                                'data' => [
                                    'user' => [
                                        'id' => Auth::user()->id,
                                        'name' => Auth::user()->name,
                                        'email' => Auth::user()->email,
                                        'mobile' => Auth::user()->mobile,
                                        'profile_image' => asset('admin-assets/images/profile/' . Auth::user()->profile_image),
                                    ],
                                    'token' => $token
                                ]
                            ]);
                       
                    } else {
                        Auth::logout();
                        return response()->json([
                            'status' => false,
                            'message' => 'Your account has been blocked'
                        ], 403);
                    }
                } else {
                    Auth::logout();
                    return response()->json([
                        'status' => false,
                        'message' => 'Invalid email or password'
                    ], 401);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid email or password'
                ], 401);
            }
        
    }

    public function sendpass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $checkuser = User::where('email', $request->email)->first();
        if (empty($checkuser)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email'
            ], 404);
        }

        $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
        $pass = helper::send_pass($checkuser->email, $checkuser->name, $password);
        if ($pass == 1) {
            $checkuser->password = Hash::make($password);
            $checkuser->save();
            return response()->json([
                'status' => true,
                'message' => 'Password sent to your email'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Email sending failed'
            ], 500);
        }
    }

    public function getProfile(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->mobile,
                'profile_image' => $user->profile_image,
                'wallet' => $user->wallet,
                'referral_code' => $user->referral_code,
                'is_verified' => $user->is_verified,
            ]
        ]);
    }
    public function editprofile(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required',
            'profile_image' => 'sometimes|image',
        ], [
            'name.required' => 'Name is required',
            'profile_image.image' => 'Please upload a valid image file',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $checkuser = User::find($user->id);

        if ($request->hasFile('profile_image')) {
            if ($checkuser->profile_image != "unknown.png" && file_exists(env('ASSETSPATHURL') . 'admin-assets/images/profile/' . $checkuser->profile_image)) {
                unlink(env('ASSETSPATHURL') . 'admin-assets/images/profile/' . $checkuser->profile_image);
            }
            $file = $request->file("profile_image");
            $filename = 'profile-' . time() . "." . $file->getClientOriginalExtension();
            $file->move(env('ASSETSPATHURL') . 'admin-assets/images/profile', $filename);
            $checkuser->profile_image = $filename;
        }

        if ($request->has('name')) {
            $checkuser->name = $request->name;
        }

        $checkuser->save();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => [
                'user' => [
                    'id' => $checkuser->id,
                    'name' => $checkuser->name,
                    'email' => $checkuser->email,
                    'mobile' => $checkuser->mobile,
                    'profile_image' => $checkuser->profile_image,
                ]
            ]
        ]);
    }
    public function send_email_status(Request $request)
    {
        $user = auth()->user();
        if (!$user || $user->type != 2) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated or invalid user type'
            ], 401);
        }

        $checkuser = User::find($user->id);
        $checkuser->is_mail = $checkuser->is_mail == 1 ? 2 : 1;
        $checkuser->save();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => [
                'is_mail' => $checkuser->is_mail
            ]
        ]);
    }
    public function referearn(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'referral_code' => $user->referral_code,
                'referral_amount' => helper::appdata()->referral_amount ?? 0,
            ]
        ]);
    }
    public function updatepassword(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password'
        ], [
            'old_password.required' => 'Old password is required',
            'new_password.required' => 'New password is required',
            'confirm_password.required' => 'Confirm password is required',
            'confirm_password.same' => 'Confirm password must match new password'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Old password is incorrect'
            ], 400);
        }

        if ($request->old_password == $request->new_password) {
            return response()->json([
                'status' => false,
                'message' => 'New password must be different from old password'
            ], 400);
        }

        $pass = User::find($user->id);
        $pass->password = Hash::make($request->new_password);
        $pass->save();

        return response()->json([
            'status' => true,
            'message' => 'Success'
        ]);
    }
    
    public function logout(Request $request)
    {
        $user = $request->user(); // get authenticated user via request
    
        if ($user) {
            // Delete all tokens if using Sanctum
            if (method_exists($user, 'tokens')) {
                $user->tokens()->delete();
            }
        }
    
    
        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    public function getOrders(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ], 401);
        }
        $getorders = Order::with('user_info', 'items')->where('user_id', $user->id)->get();

        $getorders = $getorders->map(function ($order) {
            return [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'branch_id' => $order->branch_id,
                'status' => $order->status,
                'grand_total' => (float)$order->grand_total,
                'discount_amount' => (float)$order->discount_amount,
                'tax_amount' => (float)$order->tax_amount,
                'tip' => (float)$order->tip,
                'payment_status' => $order->payment_status == 2 ? 'paid' : 'unpaid',
                'payment_method' => $order->transaction_type == 15 ? 'card' : ($order->transaction_type == 1 ? 'cod' : 'unknown'),
                'order_notes' => $order->order_notes,
                'pickup_date' => $order->delivery_date,
                'pickup_time' => $order->delivery_time,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
                'items' => $order->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'item_id' => $item->item_id,
                        'item_name' => $item->item_name,
                        'item_image' => json_decode($item->item_image, true)['image_url'] ?? null,
                        'quantity' => (int)$item->qty,
                        'unit_price' => (float)$item->item_price,
                        'item_total' => ((float)$item->item_price + (float)$item->addons_total_price) * (int)$item->qty,
                        'addons' => $item->addons_id ? array_map(function($id, $name, $price) {
                            return [
                                'id' => $id,
                                'name' => $name,
                                'price' => (float)$price
                            ];
                        }, 
                        explode('|', $item->addons_id),
                        explode('|', $item->addons_name),
                        explode('|', $item->addons_price)) : [],
                        'addons_total' => (float)$item->addons_total_price,
                        'special_instructions' => $item->special_instructions
                    ];
                }),
                'summary' => [
                    'subtotal' => (float)$order->grand_total - (float)$order->tax_amount - (float)$order->delivery_charge - (float)$order->tip + (float)$order->discount_amount,
                    'tax' => (float)$order->tax_amount,
                    'discount' => (float)$order->discount_amount,
                    'delivery_charge' => (float)$order->delivery_charge,
                    'tip' => (float)$order->tip,
                    'grand_total' => (float)$order->grand_total
                ]
            ];
        });
        return response()->json([
            'status' => true,
            'data' => $getorders
        ]);
    }

}
