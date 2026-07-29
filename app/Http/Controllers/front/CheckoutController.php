<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Helpers\helper;
use App\Helpers\whatsapp_helper;
use App\Models\Branch;
use App\Models\CustomerAddress;
use App\Models\State;
use App\Models\PrintJob;
use App\Services\StarCloudPrinterService;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CustomStatus;
use App\Models\Transaction;
use App\Models\DealCategory;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\TopDeals;
use App\Models\User;
use App\Models\Payment;
use App\Models\Settings;
use App\Models\Shippingarea;
use App\Models\SystemAddons;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Time;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use DateTime;
use Exception;
use Stripe;

class CheckoutController extends Controller
{

    public function index(Request $request)
    {
        session()->forget('last_url');
        $branchId = session()->get('branch_id');

        if (session()->get('order_type') == 2) {
            session()->forget('addressdata');
        }
        $getsettings = Settings::first();
        if (Auth::user() && Auth::user()->type == 2) {
            $getaddresses = Address::select('id', 'user_id', 'address_type', 'address', 'landmark', 'postal_code', 'is_default', 'title')->where('user_id', Auth::user()->id)->orderbyDesc('id')->get();
            $getcartlist = Cart::where('user_id', Auth::user()->id)->orderByDesc('id')->get();
            $getpaymentmethods = Payment::select(
                'id',
                'unique_identifier',
                'environment',
                'payment_name',
                'payment_type',
                'currency',
                'public_key',
                'secret_key',
                'encryption_key',
                'image'
            )
                ->where('is_available', 1)
                ->where(function ($query) use ($branchId) {
                    $query->where('payment_type', 1) // Allow COD without branch check
                    ->orWhere('branch_id', $branchId); // Apply branch_id check for others
                })
                ->where('is_activate', '1')
                ->orderBy('reorder_id')
                ->get();
        } else {
            $getaddresses = array();
            $getcartlist = Cart::where('session_id', Session::getId())->orderByDesc('id')->get();

            $getpaymentmethods = Payment::select(
                'id',
                'unique_identifier',
                'environment',
                'payment_name',
                'payment_type',
                'currency',
                'public_key',
                'secret_key',
                'encryption_key',
                'image'
            )
                ->where('is_available', 1)
                ->where(function ($query) use ($branchId) {
                    $query->where('payment_type', 1) // Allow COD without branch check
                    ->orWhere('branch_id', $branchId); // Apply branch_id check for others
                })
                ->where('is_activate', '1')
                ->orderBy('reorder_id')
                ->get();
        }
        $producttax = 0;
        $tax_name = [];
        $tax_price = [];

        foreach ($getcartlist as $cart) {
            $taxlist = helper::gettax($cart->tax);
            if (!empty($taxlist)) {
                foreach ($taxlist as $tax) {
                    if (!empty($tax)) {
                        if (!in_array($tax->name, $tax_name)) {
                            $tax_name[] = $tax->name;

                            if ($tax->type == 1) {
                                $price = $tax->tax * $cart->qty;
                            }

                            if ($tax->type == 2) {
                                $price = ($tax->tax / 100) * ($cart->addons_total_price + $cart->item_price) * $cart->qty;
                            }
                            $tax_price[] = $price;
                        } else {
                            if ($tax->type == 1) {
                                $price = $tax->tax * $cart->qty;
                            }

                            if ($tax->type == 2) {
                                $price = ($tax->tax / 100) * ($cart->addons_total_price + $cart->item_price) * $cart->qty;
                            }
                            $tax_price[array_search($tax->name, $tax_name)] += $price;
                        }
                    }
                }
            }
        }
        $taxArr['tax'] = $tax_name;
        $taxArr['rate'] = $tax_price;
        $states = State::all();
        $branches = Branch::with('state')->get();
        $shippingarea = Shippingarea::with('state')->get();
        $address = CustomerAddress::where('user_id', auth()->id())->orWhere('session_id', session::getId())->with('state')->first();
        if (!$address) {
            $address = (object)[
                'address_type' => '', // Default or empty value
                'state_id' => null, // For the relationship
                'other_field' => '', // Add other fields as needed
            ];
        }

        $discount = helper::calculateDiscount($getcartlist);


        if (count($getcartlist) > 0) {
            return view('web.checkout.checkout', compact('getaddresses', 'getpaymentmethods', 'getcartlist', 'taxArr', 'getsettings', 'shippingarea', 'address', 'states', 'branches', 'discount'));
        } else {
            return redirect()->back();
        }
    }

    public function isopenclose(Request $request)
    {
        if ($request->buynow == null || $request->buynow == 0) {
            $buynow = 0;
        } else {
            $buynow = 1;
        }

        if (@helper::appdata()->timezone != "") {
            date_default_timezone_set(helper::appdata()->timezone);
        }
        $admin = User::first();
        $date = date('Y/m/d h:i:sa');
        if ($admin->is_online == 1) {
            if (Auth::user() && Auth::user()->type == 2) {
                $cartdata = Cart::where('user_id', Auth::user()->id)->get();

            } else {
                $cartdata = Cart::where('session_id', Session::getId())->get();
            }

            if ($request->qty > helper::appdata()->max_order_qty) {
                $msg = trans('messages.order_qty_less_then') . ' : ' . helper::appdata()->max_order_qty;
                return response()->json(['status' => 2, 'message' => $msg], 200);
            } elseif (count($cartdata) <= 0) {
                return response()->json(['status' => 2, 'message' => trans('messages.cart_is_empty')], 200);
            } elseif ($request->order_amount < helper::appdata()->min_order_amount || $request->order_amount > helper::appdata()->max_order_amount) {
                $msg = trans('messages.order_amount_must_between') . ' ' . helper::currency_format(helper::appdata()->min_order_amount) . ' and ' . helper::currency_format(helper::appdata()->max_order_amount);
                return response()->json(['status' => 2, 'message' => $msg], 200);
            } else {
                if (@helper::checkaddons('customer_login')) {
                    if (Auth::user() && Auth::user()->type == 2) {
                        return response()->json(['status' => 3, 'message' => trans('messages.success')], 200);
                    } else {
                        if (helper::appdata()->login_required == 1) {
                            if (helper::appdata()->is_checkout_login_required == 1) {
                                return response()->json(['status' => 4, 'message' => trans('messages.success')], 200);
                            } else {
                                return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
                            }
                        } else {
                            return response()->json(['status' => 3, 'message' => trans('messages.success')], 200);
                        }
                    }
                } else {
                    return response()->json(['status' => 3, 'message' => trans('messages.success')], 200);
                }
            }
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.restaurant_closed')], 200);
        }
    }

    public function placeorder(Request $request)
    {
        try {
            date_default_timezone_set(@helper::appdata()->timezone);
            DB::beginTransaction();

            $transaction_type = 15; // ✅ STRIPE ONLY

            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'mobile' => 'required',
                'grand_total' => 'required|numeric|min:0',
            ]);

            $branchId = session()->get('branch_id');
            $tip = $request->tip ?? 0;
            $grand_total = $request->grand_total + $tip;

            // -------------------- CART --------------------
            if (Auth::check() && Auth::user()->type == 2) {
                $user = Auth::user();
                $cartdata = Cart::where('user_id', $user->id)->get();
                $user_id = $user->id;
            } else {
                $cartdata = Cart::where('session_id', Session::getId())->get();

                if ($cartdata->isEmpty()) {
                    return response()->json(['status' => 0, 'message' => trans('messages.cart_is_empty')]);
                }

                $guestUser = User::firstOrCreate(
                    ['email' => $request->email],
                    [
                        'name' => $request->name,
                        'mobile' => $request->mobile,
                        'password' => Hash::make('password'),
                        'type' => 2,
                    ]
                );

                $guestUser->branch_id = $branchId;
                $guestUser->save();

                $user_id = $guestUser->id;
            }

            if ($cartdata->isEmpty()) {
                return response()->json(['status' => 0, 'message' => trans('messages.cart_is_empty')]);
            }

            // -------------------- DEAL VALIDATION --------------------
            $dealIdsInCart = $cartdata->whereNotNull('deal_id')->pluck('deal_id')->unique();
            foreach ($dealIdsInCart as $dealId) {
                $deal = TopDeals::find($dealId);
                if (!$deal || $deal->deal_type != 3) continue;

                $dealCartItems   = $cartdata->where('deal_id', $dealId);
                $dealCategories  = DealCategory::where('deal_id', $dealId)->get();

                $totalEligibleSets = null;
                $freeLimits        = [];

                foreach ($dealCategories as $category) {
                    $categoryQty = (int) $dealCartItems->where('deal_category_id', $category->id)->sum('qty');

                    if ($category->is_free) {
                        $freeLimits[$category->id] = $category->quantity;
                    } else {
                        $sets = intdiv($categoryQty, $category->quantity);
                        $totalEligibleSets = is_null($totalEligibleSets) ? $sets : min($totalEligibleSets, $sets);
                    }
                }

                $totalEligibleSets = $totalEligibleSets ?? 0;

                foreach ($dealCategories->where('is_free', 1) as $freeCategory) {
                    $freeQty    = (int) $dealCartItems->where('deal_category_id', $freeCategory->id)->sum('qty');
                    $maxAllowed = $totalEligibleSets * ($freeLimits[$freeCategory->id] ?? 0);

                    if ($freeQty > $maxAllowed) {
                        DB::rollback();
                        return response()->json([
                            'status'  => 0,
                            'message' => 'Your cart contains more discounted items than this deal allows. Please remove the extra items and try again.',
                        ]);
                    }
                }
            }

            // -------------------- ORDER NUMBER --------------------
            $lastOrder = Order::latest('id')->first();
            $start = helper::appdata()->order_number_start;

            $digit = (!$lastOrder || $lastOrder->order_number_start != $start)
                ? $start
                : $lastOrder->order_number_digit + 1;

            $order_number = helper::appdata()->order_prefix . $digit;

            // -------------------- ORDER --------------------
            $order = new Order();
            $order->order_number = $order_number;
            $order->order_number_digit = $digit;
            $order->order_number_start = $start;
            $order->user_id = $user_id;
            $order->order_type = $request->order_type;
            $order->branch_id = $branchId;
            $order->address = $request->address ?? null;
            $order->name = $request->name;
            $order->email = $request->email;
            $order->mobile = $request->mobile;
            $order->tax_amount = $request->tax ?? 0;
            $order->tax_name = $request->tax_name ?? null;
            $order->delivery_charge = helper::number_format($request->delivery_charge ?? 0);
            $order->grand_total = helper::number_format($grand_total);
            $order->tip = helper::number_format($tip);
            $order->order_notes = $request->order_notes;
            $order->order_from = "web";
            $order->status = 4; // default pending
            $order->status_type = 1;
            $order->delivery_date = $request->delivery_date;
            $order->delivery_time = $request->delivery_time;
            $order->transaction_type = 15;
            $order->payment_status = 1;
            $order->save();

            // -------------------- ORDER DETAILS --------------------
            foreach ($cartdata as $cart) {
                OrderDetails::create([
                    'order_id' => $order->id,
                    'user_id' => $user_id,
                    'item_id' => $cart->item_id,
                    'deal_id' => $cart->deal_id,
                    'custom_pizza_id' => $cart->custom_pizza_id,
                    'item_name' => $cart->item_name,
                    'item_type' => $cart->item_type,
                    'item_image' => $cart->item_image,
                    'crust_id' => $cart->crust_id,
                    'size_id' => $cart->size_id,
                    'dipping_quantity' => $cart->dipping_quantity,
                    'dipping_name' => $cart->dipping_name,
                    'dipping_price' => $cart->dipping_price,
                    'tax' => $cart->tax,
                    'qty' => $cart->qty,
                    'item_price' => $cart->item_price,
                    'addons_id' => $cart->addons_id,
                    'addons_name' => $cart->addons_name,
                    'addons_price' => $cart->addons_price,
                    'addons_total_price' => $cart->addons_total_price,
                    'extras_id' => $cart->extras_id,
                    'extras_name' => $cart->extras_name,
                    'extras_price' => $cart->extras_price,
                    'extras_total_price' => $cart->extras_total_price,
                ]);
            }

            // -------------------- CLEAR CART --------------------
            Auth::check()
                ? Cart::where('user_id', $user_id)->delete()
                : Cart::where('session_id', Session::getId())->delete();

            // -------------------- STRIPE --------------------

            $stripekey = helper::stripe_data()->secret_key;
            Stripe\Stripe::setApiKey($stripekey);
            $stripe = Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => ['name' => $order_number],
                        'unit_amount' => round($grand_total * 100),
                    ],
                    'quantity' => 1,
                ]],
                'metadata' => [
                    'company_name' => 'CheesyBite',
                    'logo_url' => 'https://thecheesybite.com/assets/images/logo.png',
                    'order_number' => $order_number,
                    'branch_id' => $branchId,
                ],
                'mode' => 'payment',
                'success_url' => route('payment.success', ['order' => $order_number]),
                'cancel_url' => route('payment.cancel', ['order' => $order_number]),
            ]);

            $order->stripe_session_id = $stripe->id;
            $order->save();

            $this->createPrintJob($order->id);

            DB::commit();

            return response()->json([
                'status' => 1,
                'redirecturl' => $stripe->url,
            ]);

        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th);
            return response()->json(['status' => 0, 'message' => 'Order failed']);
        }
    }
    public function createPrintJob($id)
    {
        $branch_id = session()->get('branch_id');
        $branch = Branch::find($branch_id);
        PrintJob::create([
            'printer_id' => $branch->printer_id,
            'mac_id' => $branch->mac_id,
            'order_id' => $id,
        ]);
    }

    public function timeslot(Request $request)
    {
        try {
            $branchId = session()->get('branch_id');
            $slots = [];

            date_default_timezone_set(helper::appdata()->timezone);

            if (!empty($request->inputDate)) {

                $day = date('l', strtotime(helper::date_format($request->inputDate)));

                $time = Time::where('day', $day)
                    ->where('branch_id', $branchId)
                    ->first();

                // safety check
                if (!$time || $time->always_close == 1) {
                    return "1"; // same behavior as your original code
                }

                // interval calculation
                if (helper::appdata()->interval_type == 2) {
                    $minute = (float)helper::appdata()->interval_time * 60;
                } else {
                    $minute = helper::appdata()->interval_time;
                }

                $starttime = [];
                $temparray = [];

                // single period (open → close)
                $period = new CarbonPeriod(
                    date("H:i", strtotime($time->open_time)),
                    $minute . ' minutes',
                    date("H:i", strtotime($time->close_time))
                );

                // build time points
                foreach ($period as $item) {
                    $starttime[] = helper::time_format($item);
                }

                // build slots (pair consecutive times)
                for ($i = 0; $i < count($starttime) - 1; $i++) {
                    $temparray[] = $starttime[$i] . ' - ' . $starttime[$i + 1];
                }

                $currenttime = Carbon::now()->format('H:i');
                $current_date = Carbon::today()->toDateString();
                $input_date = Carbon::parse($request->inputDate)->toDateString();

                foreach ($temparray as $item) {

                    $ordercount = Order::where('delivery_date', $request->inputDate)
                        ->where('delivery_time', $item)
                        ->count();

                    if ($ordercount < helper::appdata()->perslot_booking_limit) {

                        $slot_parts = explode(' - ', $item);

                        if ($input_date === $current_date) {
                            if ($currenttime < date('H:i', strtotime($slot_parts[0]))) {
                                $slots[] = [
                                    'slot' => $this->formatTimeSlotTo12Hour($item),
                                ];
                            }
                        } else {
                            $slots[] = [
                                'slot' => $this->formatTimeSlotTo12Hour($item),
                            ];
                        }
                    }
                }
            }

            return $slots;

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => trans('messages.wrong')
            ], 200);
        }
    }

    private function formatTimeSlotTo12Hour($timeSlot)
    {
        $parts = explode(' - ', $timeSlot);
        
        $startTime = date('g:i', strtotime($parts[0])); // 'g:i' = 12-hour format with minutes
        $endTime = date('g:i', strtotime($parts[1]));   // 'g:i' = 12-hour format with minutes
        
        return $startTime . ' - ' . $endTime;
    }

    public function stripeCheckoutSuccess($orderId)
    {
        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            Log::error('Payment success: order not found for order_number ' . $orderId);
            return redirect('/')->with('error', trans('messages.wrong'));
        }

        if ((int) $order->payment_status !== 2) {
            if (!$order->stripe_session_id) {
                return redirect('/')->with('error', trans('messages.unable_to_complete_payment'));
            }

            try {
                $stripekey = helper::stripe_data()->secret_key;
                Stripe\Stripe::setApiKey($stripekey);
                $session = Stripe\Checkout\Session::retrieve($order->stripe_session_id);
            } catch (\Throwable $e) {
                Log::error('Stripe session verification failed: ' . $e->getMessage());
                return redirect('/')->with('error', trans('messages.unable_to_complete_payment'));
            }

            if ($session->payment_status !== 'paid') {
                return redirect('/')->with('error', trans('messages.unable_to_complete_payment'));
            }

            $order->payment_status = 2;
            $order->save();
        }

        if (Auth::check()) {
            $user = Auth::user();
            Cart::where('user_id', $user->id)->delete();

            if ($user->is_notification == 1) {
                $title = trans('labels.order_placed');
                $body = "Your Order " . $orderId . " has been placed.";
                helper::push_notification($user->token, $title, $body, "order", $order->id);
            }
        } else {
            $sessionId = Session::getId();
            Cart::where('session_id', $sessionId)->delete();

            $title = trans('labels.order_placed');
            $body = "Your Order " . $orderId . " has been placed.";
            helper::push_notification($sessionId, $title, $body, "order", $order->id);
        }

        $branchId = Session::get('branch_id');
        $location = Branch::where('id', $branchId)->first()->slug;

        return redirect(url("/$location/success-$orderId"));
    }

    public function paymentsuccess(Request $request)
    {
        try {
            if ($request->has('paymentId')) {
                $paymentId = request('paymentId');
                $response = ['status' => 1, 'msg' => 'paid', 'paymentId' => $paymentId];
            }
            if ($request->has('payment_id')) {
                $paymentId = request('payment_id');
                $response = ['status' => 1, 'msg' => 'paid', 'paymentId' => $paymentId];
            }

            if ($request->has('transaction_id')) {
                $paymentId = request('transaction_id');
                $response = ['status' => 1, 'msg' => 'paid', 'paymentId' => $paymentId];
            }

        } catch (\Exception $e) {
            $response = ['status' => 0, 'msg' => $e->getMessage()];
        }

        $request = new Request($response);

        return $this->placeorder($request);
    }

    public function paymentfail()
    {
        if (count(request()->all()) > 0) {
            return redirect('/checkout?buynow=' . Session::get('buynow'))->with('error', trans('messages.unable_to_complete_payment'));
        } else {
            return redirect('/checkout?buynow=' . Session::get('buynow'));
        }
    }
}
