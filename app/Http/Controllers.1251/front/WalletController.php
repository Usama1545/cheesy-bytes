<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\helper;
use App\Models\Payment;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Session;
use Stripe;

class WalletController extends Controller
{
    public function index(Request $request)
    {
        $gettransactions = Transaction::select('transaction.id', 'transaction.user_id', 'transaction.order_id', 'transaction.order_number', 'transaction.amount', 'transaction.transaction_id', 'transaction.transaction_type', 'transaction.username', 'transaction.created_at', 'payment.payment_name')
            ->leftJoin('payment', 'payment.payment_type', 'transaction.transaction_type')
            ->where('user_id', Auth::user()->id)
            ->orderByDesc('id')
            ->paginate(10);
        $totalcredited = Transaction::whereNotIn('transaction_type', array(1))->sum('amount');
        $totaldebited = Transaction::whereIn('transaction_type', array(1, 13))->sum('amount');

        return view('web.wallet.index', compact('gettransactions', 'totalcredited', 'totaldebited'));
    }
    public function addform(Request $request)
    {
        $getpaymentmethods = Payment::select('id', 'unique_identifier', 'environment', 'payment_name', 'payment_type', 'currency', 'public_key', 'secret_key', 'encryption_key', 'image')->whereNotIn('id', array(1, 2))->where('is_available', 1)->where('is_activate', '1')->orderBy('reorder_id')->get();
        return view('web.wallet.addmoney', compact('getpaymentmethods'));
    }
    public function addwallet(Request $request)
    {
        if ($request->status == 1) {
            $userdata = Session::get('userdata');
            $amount = $userdata['grand_total'];
            $transaction_type = $userdata['transaction_type'];
        } else {
            $amount = $request->amount;
            $transaction_type = $request->transaction_type;
        }

        try {
            $checkuser = User::where('id', Auth::user()->id)->where('is_available', 1)->where('is_deleted', 2)->where('type', 2)->first();
            if (empty($checkuser)) {
                return response()->json(["status" => 0, "message" => trans('messages.invalid_user')], 200);
            }
            if ($transaction_type == "") {
                return response()->json(["status" => 0, "message" => trans('messages.payment_selection_required')], 200);
            }
            if ($amount == "") {
                return response()->json(["status" => 0, "message" => trans('messages.enter_amount')], 200);
            }
            if ($transaction_type == 4) {
                try {
                    $stripekey = helper::stripe_data()->secret_key;
                    Stripe\Stripe::setApiKey($stripekey);
                    $token = $request->transaction_id;
                    $charge = Stripe\Charge::create([
                        'amount' => round($amount * 100),
                        'currency' => helper::stripe_data()->currency,
                        "description" => "SingleReastaurant-WalletRecharge",
                        'source' => $token,
                    ]);
                    $transaction_id = $charge->id;
                } catch (\Exception $e) {
                    return response()->json(['status' => 0, 'message' => trans('messages.unable_to_complete_payment')], 200);
                }
            } else {
                if ($request->transaction_id == "") {
                    return response()->json(["status" => 0, "message" => trans('messages.enter_transaction_id')], 200);
                }
                $transaction_id = $request->transaction_id;
            }
            $checkuser->wallet += $amount;
            $checkuser->save();
            // 3 = added-money-wallet-using- Razorpay 
            // 4 = added-money-wallet-using- Stripe 
            // 5 = added-money-wallet-using- Flutterwave 
            // 6 = added-money-wallet-using- Paystack
            // 7 = added-money-wallet-using- mecadopago
            // 8 = added-money-wallet-using- myfatoorah
            // 9 = added-money-wallet-using- paypal
            // 10 = added-money-wallet-using- toyyibpay

            $transaction = new Transaction();
            $transaction->user_id = $checkuser->id;
            $transaction->transaction_id = $transaction_id;
            $transaction->transaction_type = $transaction_type;
            $transaction->amount = $amount;
            $transaction->save();


            if ($transaction_type == 7 || $transaction_type == 8 || $transaction_type == 9 || $transaction_type == 10 || $transaction_type == 11 || $transaction_type == 12 || $transaction_type == 13 || $transaction_type == 14) {
                return redirect('wallet')->with('success', trans('messages.add_money_success'));
            }

            return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }


    public function addsuccess(Request $request)
    {
        try {
            if ($request->has('paymentId')) {
                $paymentId = request('paymentId');
                $response = ['status' => 1, 'msg' => 'paid', 'transaction_id' => $paymentId];
            }
            if ($request->has('payment_id')) {
                $paymentId = request('payment_id');
                $response = ['status' => 1, 'msg' => 'paid', 'transaction_id' => $paymentId];
            }

            if ($request->has('transaction_id')) {
                $paymentId = request('transaction_id');
                $response = ['status' => 1, 'msg' => 'paid', 'transaction_id' => $paymentId];
            }

            if (Session::get('payment_type') == "11") {
                $checkstatus = app('App\Http\Controllers\addons\PayTabController')->checkpaymentstatus(Session::get('tran_ref'));
                if ($checkstatus == "A") {
                    $paymentId = Session::get('tran_ref');
                    $response = ['status' => '1', 'msg' => 'paid', 'transaction_id' => $paymentId];
                } else {
                    return redirect('/wallet')->with('error', trans('messages.unable_to_complete_payment'));
                }
            }

            if (Session::get('payment_type') == "12") {
                if ($request->code == "PAYMENT_SUCCESS") {
                    $paymentId = $request->transactionId;
                    $response = ['status' => 1, 'msg' => 'paid', 'transaction_id' => $paymentId];
                } else {
                    return redirect('/wallet')->with('error', trans('messages.unable_to_complete_payment'));
                }
            }

            if (Session::get('payment_type') == "13") {
                $checkstatus = app('App\Http\Controllers\addons\MollieController')->checkpaymentstatus(Session::get('tran_ref'));

                if ($checkstatus == "A") {
                    $paymentId = Session::get('tran_ref');
                    $response = ['status' => 1, 'msg' => 'paid', 'transaction_id' => $paymentId];
                } else {
                    return redirect('/wallet')->with('error', trans('messages.unable_to_complete_payment'));
                }
            }

            if (Session::get('payment_type') == "14") {

                if ($request->status == "Completed") {
                    $paymentId = $request->transaction_id;
                    $response = ['status' => 1, 'msg' => 'paid', 'transaction_id' => $paymentId];
                } else {
                    return redirect('/wallet')->with('error', trans('messages.unable_to_complete_payment'));
                }
            }
        } catch (\Exception $e) {
            $response = ['status' => 0, 'msg' => $e->getMessage()];
        }

        $request = new Request($response);
        return $this->addwallet($request);
    }

    public function addfail(Request $request)
    {
        if (count(request()->all()) > 0) {
            return redirect('/wallet')->with('error', trans('messages.unable_to_complete_payment'));
        } else {
            return redirect('/wallet');
        }
    }
}
