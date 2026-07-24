<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\helper;
use App\Helpers\whatsapp_helper;
use App\Models\Branch;
use App\Models\PrintJob;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CustomStatus;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\User;
use App\Models\Payment;
use App\Models\Settings;
use App\Models\Time;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Exception;
use Stripe;

class CheckoutController extends Controller
{

    public function index(Request $request)
    {
        log::info("i am called");
        try {
            $branchId = $request->branch_id;
            
            $user = auth('sanctum')->user();
            $settings = Settings::first();
                      
            
            // Get cart items based on user or session
            if ($user) {
                $getcartlist = Cart::where('user_id', $user->id)
                                ->with(['item', 'addons', 'taxes'])
                                ->orderByDesc('id')
                                ->get();
            } else {
                $sessionId = $request->header('X-Session-Id');
                if (!$sessionId) {
                    return response()->json([
                        'status' => false,
                        'message' => 'user is not authenticated and Session ID is required for guest users',
                        'data' => []
                    ], 400);
                }
                $getcartlist = Cart::where('session_id', $sessionId)
                                ->with(['item', 'addons', 'taxes'])
                                ->orderByDesc('id')
                                ->get();
            }
            
            // Calculate taxes
            $producttax = 0;
            $tax_name = [];
            $tax_price = [];
            $totalCartValue = 0;
            $totalItems = 0;
            
            foreach ($getcartlist as $cart) {
                $taxlist = helper::gettax($cart->tax);
                if (!empty($taxlist)) {
                    foreach ($taxlist as $tax) {
                        if (!empty($tax)) {
                            $itemTotal = ($cart->addons_total_price + $cart->extras_total_price + $cart->item_price) * $cart->qty;
                            
                            if (!in_array($tax->name, $tax_name)) {
                                $tax_name[] = $tax->name;
                                
                                if ($tax->type == 1) {
                                    $price = $tax->tax * $cart->qty;
                                } elseif ($tax->type == 2) {
                                    $price = ($tax->tax / 100) * $itemTotal;
                                }
                                $tax_price[] = round($price,2);
                            } else {
                                if ($tax->type == 1) {
                                    $price = $tax->tax * $cart->qty;
                                } elseif ($tax->type == 2) {
                                    $price = ($tax->tax / 100) * $itemTotal;
                                }
                                $tax_price[array_search($tax->name, $tax_name)] += $price;
                            }
                        }
                    }
                }
                
                $totalCartValue += ($cart->addons_total_price + $cart->extras_total_price + $cart->item_price) * $cart->qty;
                $totalItems += $cart->qty;
            }
            
            $taxArr = [
                'tax_names' => $tax_name,
                'tax_amounts' => $tax_price,
                'total_tax' => array_sum($tax_price)
            ];
            
            // Calculate discount
            $discount = helper::calculateDiscountOnApi($getcartlist, $branchId, $user);
            
            // Calculate totals
            $subtotal = $totalCartValue;
            $totalTax = $taxArr['total_tax'];
            $shippingCharge = 0; // You'll need to calculate this based on address
            $grandTotal = $subtotal + $totalTax + $shippingCharge - ($discount['discount_amount'] ?? 0);
            
            if ($getcartlist->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Your cart is empty',
                    'data' => []
                ], 200);
            }
            
            // Prepare response data
            $responseData = [
                'cart_summary' => [
                    'total_items' => $totalItems,
                    'subtotal' => round($subtotal, 2),
                    'tax_breakdown' => $taxArr,
                    'tax_total' => round($totalTax, 2),
                    'discount' => [
                        'amount' => round($discount['discount_amount'] ?? 0, 2),
                        'type' => $discount['discount_type'] ?? null,
                    ],
                    'estimated_shipping' => round($shippingCharge, 2),
                    'grand_total' => round($grandTotal, 2),
                    'currency' => $settings->currency ?? 'USD'
                ],
                'cart_items' => $getcartlist->map(function ($item) {
                    $image = json_decode($item->item_image, true);
                    return [
                        'id' => $item->id,
                        'item_id' => $item->item_id,
                        'item_name' => $item->item_name ?? '',
                        'quantity' => $item->qty,
                        'unit_price' => round($item->item_price, 2),
                        'addons_total' => round($item->addons_total_price, 2),
                        'item_total' => round(($item->item_price + $item->addons_total_price) * $item->qty, 2),
                        'image' => $image['image_url'] ?? '',
                        'special_instructions' => $item->special_instructions
                    ];
                }),
                'settings' => [
                    'currency' => $settings->currency ?? 'USD',
                    'currency_symbol' => $settings->currency_symbol ?? '$',
                    'tax_inclusive' => $settings->tax_inclusive ?? false,
                    'minimum_order' => $settings->minimum_order ?? 0,
                    'can_use_credits' => $user ? $settings->min_redeem_points <= $user->wallet : false,
                    'has_credits' => $user ? $user->wallet : 0,
                    'dollar_per_credit' => $settings->dollar_per_point,
                ]
            ];
            
            return response()->json([
                'status' => true,
                'message' => 'Checkout data retrieved successfully',
                'data' => $responseData
            ], 200);
            
        } catch (\Exception $e) {
            log::info([
                'error'=> $e->getMessage(),
            ]);
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve checkout data',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function placeOrder(Request $request)
    {
        date_default_timezone_set(@helper::appdata()->timezone);
        try {
            DB::beginTransaction();
            
            $user = auth('sanctum')->user();
            $sessionId = $request->header('X-Session-Id');
            $branchId = $request->branch_id;

            if (!$branchId) {
                return response()->json([
                    'status' => false,
                    'message' => 'branch_id is required'
                ], 400);
            }

            // Validate required fields
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'mobile' => 'required',
                'order_notes' => 'nullable',
                'pickup_date' => 'nullable|date',
                'pickup_time' => 'nullable',
                'tip' => 'nullable|numeric|min:0',
                'coupon_code' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Get cart items based on user or session
            if ($user && $user->type == 2) {
                $cartdata = Cart::where('user_id', $user->id)->get();
            } else {
                if (!$sessionId) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Session ID is required for guest users'
                    ], 400);
                }
                $cartdata = Cart::where('session_id', $sessionId)->get();
            }

            if ($cartdata->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Your cart is empty'
                ], 400);
            }

            // Calculate discount based on coupon code if provided
            $discountAmount = 0;
            $couponCode = null;

            $otherDiscount = helper::calculateDiscountOnApi($cartdata, $branchId, $user);

            if ($otherDiscount) {
                $discountAmount += round($otherDiscount['discount_amount'] ?? 0, 2);
            }

            if ($request->filled('coupon_code')) {
                $couponDiscount = helper::calculateCouponDiscount(
                    $cartdata,
                    $request->coupon_code,
                    $user ? $user->id : null
                );

                if ($couponDiscount > 0) {
                    $discountAmount += $couponDiscount;  // ✅ add instead of overwrite
                    $couponCode = $request->coupon_code;
                }
            }
            // Generate order number
            $getLastOrder = Order::select('order_number', 'order_number_digit', 'order_number_start')
                ->orderBy('id', 'DESC')
                ->first();

            $appData = helper::appdata();
            
            if (empty($getLastOrder->order_number_digit) || 
                $getLastOrder->order_number_start != $appData->order_number_start) {
                $newOrderNumberDigit = $appData->order_number_start;
            } else {
                $newOrderNumberDigit = (int)$getLastOrder->order_number_digit + 1;
            }

            $orderNumber = $appData->order_prefix . str_pad($newOrderNumberDigit, 0, STR_PAD_LEFT);

            $producttax = 0;
            $tax_name = [];
            $tax_price = [];
            $totalCartValue = 0;
            $totalItems = 0;
            //calculate tax 
            foreach ($cartdata as $cart) {
                $taxlist = helper::gettax($cart->tax);
                if (!empty($taxlist)) {
                    foreach ($taxlist as $tax) {
                        if (!empty($tax)) {
                            $itemTotal = ($cart->addons_total_price + $cart->extras_total_price + $cart->item_price) * $cart->qty;
                            if (!in_array($tax->name, $tax_name)) {
                                $tax_name[] = $tax->name;
                                
                                if ($tax->type == 1) {
                                    $price = $tax->tax * $cart->qty;
                                } elseif ($tax->type == 2) {
                                    $price = ($tax->tax / 100) * $itemTotal;
                                }
                                $tax_price[] = round($price,2);
                            } else {
                                if ($tax->type == 1) {
                                    $price = $tax->tax * $cart->qty;
                                } elseif ($tax->type == 2) {
                                    $price = ($tax->tax / 100) * $itemTotal;
                                }
                                $tax_price[array_search($tax->name, $tax_name)] += $price;
                            }
                        }
                    }
                }
                
                $totalCartValue += ($cart->addons_total_price + $cart->extras_total_price + $cart->item_price) * $cart->qty;
                $totalItems += $cart->qty;
            }

            $taxArr = [
                'tax_names' => $tax_name,
                'tax_amounts' => $tax_price,
                'total_tax' => array_sum($tax_price)
            ];
            // Calculate totals
            $tip = $request->tip ?? 0;
            $tax = array_sum($tax_price);

            $baseAmount = max(0, $totalCartValue - $discountAmount);

            // Check user wallet if authenticated
            if ($user && $user->type == 2) {
                $checkuser = User::where('is_available', 1)
                    ->where('id', $user->id)
                    ->first();
            } else {
                $checkuser = null;
            }

            $credit_discount = 0;
            $creditsRequested = (int) $request->credits_used;

            if ($checkuser && $creditsRequested > 0) {
                $settings = Settings::first();
                $creditsRequested = min($creditsRequested, $checkuser->wallet);
                $maxCreditsAllowed = floor(
                    $baseAmount / $settings->dollar_per_point
                );
                if($creditsRequested > $maxCreditsAllowed) {
                    return response()->json([
                        'status' => false,
                        'message' => 'You can use up to ' . $maxCreditsAllowed . ' credits for this order'
                    ]);
                }
                $creditsToUse = min($creditsRequested, $maxCreditsAllowed);

                $credit_discount = $creditsToUse * $settings->dollar_per_point;
                $checkuser->wallet = max(0, $checkuser->wallet - $creditsToUse);
            }

            $grandTotal = max(
                0,
                $totalCartValue + $tip + $tax - $discountAmount - $credit_discount
            );

            // Ensure grand total is not negative
            if ($grandTotal < 0) {
                $grandTotal = 0;
                return response()->json([
                    'status' => false,
                    'message' => 'Order total cannot be zero'
                ]);
            }

            // Create order
            $order = new Order();
            $order->order_number = $orderNumber;
            $order->order_number_digit = $newOrderNumberDigit;
            $order->order_number_start = $appData->order_number_start;
            $order->user_id = $checkuser ? $checkuser->id : null;
            $order->order_type = 2; // Always pickup

            // Pickup order details
            $order->address_type = null;
            $order->address = $request->address ?? null; // Optional pickup address note
            $order->landmark = null;
            $order->postal_code = null;
            $order->country = null;
            $order->state = null;
            $order->city = null;
            $order->branch_id = $request->branch_id;
            $order->delivery_area = null; // No delivery area for pickup

            $order->name = $request->name;
            $order->email = $request->email;
            $order->mobile = $request->mobile;
            
            // Apply discount if any
            if ($couponCode) {
                $order->offer_code = $couponCode;
                $order->discount_amount = helper::number_format($discountAmount);
            } else {
                $order->offer_code = "";
                $order->discount_amount = helper::number_format($discountAmount);
            }

            $order->transaction_type = 15; // Stripe
            $order->tax_amount = helper::number_format($tax);
            $order->tax_name = $taxArr['tax_names'][0] ?? null;
            $order->delivery_charge = helper::number_format(0); // No delivery charge for pickup
            $order->grand_total = helper::number_format($grandTotal);
            $order->tip = helper::number_format($tip);
            $order->order_notes = $request->order_notes;
            $order->order_from = "api";
            $order->applied_credits = $creditsToUse ?? 0;
            $order->status = 4;
            $order->status_type = 1;
            $order->delivery_date = $request->pickup_date; // Using pickup date instead of delivery
            $order->delivery_time = $request->pickup_time; // Using pickup time instead of delivery
            $order->branch_id = $request->branch_id;
            $order->payment_status = 1; // Pending for Stripe payment

            if ($order->save()) {
                // Update or create user record
                if ($user && $user->type == 2) {
                    if ($checkuser) {
                        $checkuser->branch_id = $order->branch_id;
                        $checkuser->save();
                    }
                } else {
                    // For guest users, create or update user record
                    $guestUser = User::where('email', $request->email)
                        ->orWhere('mobile', $request->mobile)
                        ->first();

                    if ($guestUser) {
                        $guestUser->branch_id = $order->branch_id;
                        $guestUser->is_app_user = 1;
                        $guestUser->save();
                    } else {
                        $guestUser = new User();
                        $guestUser->branch_id = $order->branch_id;
                        $guestUser->name = $request->name;
                        $guestUser->email = $request->email;
                        $guestUser->mobile = $request->mobile;
                        $guestUser->password = '';
                        $guestUser->type = 2;
                        $guestUser->is_app_user = 1;
                        $guestUser->save();
                    }
                    $order->user_id = $guestUser->id;
                    $order->save();
                }

                // Calculate item totals for verification
                $cartTotal = 0;
                
                // Create order details from cart items
                foreach ($cartdata as $cart) {
                    $itemTotal = ($cart->item_price + $cart->addons_total_price + $cart->extras_total_price) * $cart->qty;
                    $cartTotal += $itemTotal;
                    
                    $orderDetail = new OrderDetails();
                    $orderDetail->order_id = $order->id;
                    $orderDetail->user_id = $checkuser ? $checkuser->id : ($guestUser->id ?? null);
                    $orderDetail->item_id = $cart->item_id;
                    $orderDetail->deal_id = $cart->deal_id ?? null;
                    $orderDetail->custom_pizza_id = $cart->custom_pizza_id ?? null;
                    $orderDetail->item_name = $cart->item_name;
                    $orderDetail->item_type = $cart->item_type;
                    $orderDetail->item_image = $cart->item_image;
                    $orderDetail->crust_id = $cart->crust_id;
                    $orderDetail->size_id = $cart->size_id;
                    $orderDetail->dipping_quantity = $cart->dipping_quantity;
                    $orderDetail->dipping_name = $cart->dipping_name;
                    $orderDetail->dipping_price = $cart->dipping_price;
                    $orderDetail->tax = $cart->tax;
                    $orderDetail->qty = $cart->qty;
                    $orderDetail->item_price = $cart->item_price;
                    $orderDetail->addons_id = $cart->addons_id;
                    $orderDetail->addons_name = $cart->addons_name;
                    $orderDetail->addons_price = $cart->addons_price;
                    $orderDetail->addons_total_price = $cart->addons_total_price;
                    $orderDetail->extras_id = $cart->extras_id;
                    $orderDetail->extras_name = $cart->extras_name;
                    $orderDetail->extras_price = $cart->extras_price;
                    $orderDetail->extras_total_price = $cart->extras_total_price;
                    $orderDetail->save();
                }

                // Verify calculated total matches request total (with tolerance)
                $calculatedTotal = $cartTotal + $tax + $tip - $discountAmount;
              
                // Clear cart after order
                if ($user && $user->type == 2) {
                    Cart::where('user_id', $user->id)->delete();
                } else {
                    Cart::where('session_id', $sessionId)->delete();
                }

                // Send notifications
                // $this->sendOrderNotifications($order, $checkuser ?? $guestUser ?? null);

                // Create Stripe checkout session
                $stripeResponse = $this->createStripePaymentIntent($order, $calculatedTotal, $branchId);
                
                if (!$stripeResponse['status']) {
                    DB::rollback();
                    return response()->json([
                        'status' => false,
                        'message' => $stripeResponse['message']
                    ], 400);
                }

                DB::commit();

                // Send WhatsApp message if enabled
                if (@helper::checkaddons('whatsapp_message')) {
                    if (whatsapp_helper::whatsapp_message_config()->order_created == 1) {
                        whatsapp_helper::whatsappmessage($orderNumber);
                    }
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Order created successfully. Proceed to payment.',
                    'data' => [
                        'order_number' => $orderNumber,
                        'order_id' => $order->id,
                        'stripe_details' => $stripeResponse,
                        'amount' => round($grandTotal, 2),
                        'currency' => 'usd',
                        'discount_applied' => $discountAmount > 0,
                        'discount_amount' => round($discountAmount, 2)
                    ]
                ], 200);

            } else {
                DB::rollback();
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to create order'
                ], 500);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            
            Log::error('Order placement failed: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Failed to place order now',
                'error' => config('app.debug') ? $th->getMessage() : null
            ], 500);
        }
    }

    /**
     * Create Stripe checkout session
     */
    /**
     * Create Stripe Payment Intent for mobile SDK integration
     */
    private function createStripePaymentIntent($order, $amount, $branchId)
    {
        try {
          
            $stripeKey = helper::branch_stripe_data($branchId);

            if (!$stripeKey) {
                return [
                    'status' => false,
                    'message' => 'Stripe configuration missing'
                ];
            }

            // log::info($stripeKey->secret_key);

            \Stripe\Stripe::setApiKey($stripeKey->secret_key);

            // Create Payment Intent for mobile SDK
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => round($amount * 100), // Convert to cents
                'currency' => 'usd',
                'metadata' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer_email' => $order->email,
                    'customer_name' => $order->name,
                    'branch_id' => $order->branch_id,
                    'order_type' => 'pickup'
                ],
                'receipt_email' => $order->email,
                'description' => 'Payment for order #' . $order->order_number,
                'capture_method' => 'automatic', // Auto-capture payments
                'setup_future_usage' => 'off_session', // Allow saving card for future
                'automatic_payment_methods' => [
                    'enabled' => true, // Let Stripe handle payment method selection
                ],
                'statement_descriptor' => substr(helper::appdata()->restaurant_name, 0, 22) ?: 'CHEESYBITE', // Max 22 chars
                'statement_descriptor_suffix' => 'ORDER' . substr($order->order_number, -4),
            ]);

            // Save Stripe payment intent ID to order
            $order->stripe_payment_intent_id = $paymentIntent->id;
            $order->save();

            return [
                'status' => true,
                'client_secret' => $paymentIntent->client_secret, // Essential for mobile SDK
                'payment_intent_id' => $paymentIntent->id,
                'amount' => round($amount, 2),
                'currency' => $paymentIntent->currency,
                'livemode' => $paymentIntent->livemode,
                'requires_action' => $paymentIntent->status === 'requires_action',
                'status' => $paymentIntent->status,
                'customer_email' => $order->email,
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'publishable_key' => $stripeKey->public_key,
            ];

        } catch (\Stripe\Exception\CardException $e) {
            // Card errors - the customer needs to fix their card details
            Log::error('Stripe Card Error: ' . $e->getMessage());
            
            return [
                'status' => false,
                'message' => 'Card error: ' . $e->getError()->message,
                'code' => $e->getError()->code,
                'type' => 'card_error'
            ];
            
        } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly
            Log::error('Stripe Rate Limit: ' . $e->getMessage());
            
            return [
                'status' => false,
                'message' => 'Too many requests. Please try again in a moment.',
                'type' => 'rate_limit'
            ];
            
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            Log::error('Stripe Invalid Request: ' . $e->getMessage());
            
            return [
                'status' => false,
                'message' => 'Invalid payment request. Please check your details.',
                'type' => 'invalid_request'
            ];
            
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            Log::error('Stripe Authentication Error: ' . $e->getMessage());
            
            return [
                'status' => false,
                'message' => 'Payment authentication failed.',
                'type' => 'authentication_error'
            ];
            
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            Log::error('Stripe Connection Error: ' . $e->getMessage());
            
            return [
                'status' => false,
                'message' => 'Network error. Please check your connection.',
                'type' => 'api_connection_error'
            ];
            
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Generic Stripe API error
            Log::error('Stripe API Error: ' . $e->getMessage());
            
            return [
                'status' => false,
                'message' => 'Payment processing error.',
                'type' => 'api_error'
            ];
            
        } catch (\Exception $e) {
            Log::error('Stripe payment intent creation failed: ' . $e->getMessage());
            
            return [
                'status' => false,
                'message' => 'Unable to create payment. Please try again.',
                'type' => 'general_error'
            ];
        }
    }

    public function createPrintJob($id, $branch_id)
    {
        $branch = Branch::findOrFail($branch_id);
        log::info(json_encode($branch));
        PrintJob::create([
            'printer_id' => $branch->printer_id,
            'mac_id' => $branch->mac_id,
            'order_id' => $id,
        ]);
    }

    public function timeslot(Request $request)
    {
        try {
            $branchId = $request->branch_id;
            $slots = [];
            date_default_timezone_set(helper::appdata()->timezone);

            if (!empty($request->inputDate)) {
                $day = date('l', strtotime(helper::date_format($request->inputDate)));

                $minute = "";
                $time = Time::where('day', $day)->where('branch_id', $branchId)->first();

                if ($time->always_close == 1) {
                    $slots = ["closed"]; // Return array with "closed" message
                } else {
                    if (helper::appdata()->interval_type == 2) {
                        $minute = (float)helper::appdata()->interval_time * 60;
                    }
                    if (helper::appdata()->interval_type == 1) {
                        $minute = helper::appdata()->interval_time;
                    }

                    $firsthalf = new CarbonPeriod(date("H:i", strtotime($time->open_time)), $minute . ' minutes', date("H:i", strtotime($time->break_start)));
                    $secondhalf = new CarbonPeriod(date("H:i", strtotime($time->break_end)), $minute . ' minutes', date("H:i", strtotime($time->close_time)));

                    $starttime = [];
                    $endtime = [];
                    
                    foreach ($firsthalf as $item) {
                        $starttime[] = helper::time_format($item);
                    }
                    foreach ($secondhalf as $item) {
                        $endtime[] = helper::time_format($item);
                    }

                    $temparray = [];
                    for ($i = 0; $i < count($starttime) - 1; $i++) {
                        $temparray[] = $starttime[$i] . ' - ' . $starttime[$i + 1];
                    }
                    for ($i = 0; $i < count($endtime) - 1; $i++) {
                        $temparray[] = $endtime[$i] . ' - ' . $endtime[$i + 1];
                    }

                    $currenttime = Carbon::now()->format('H:i');
                    $input_date = Carbon::parse($request->inputDate)->toDateString();
                    $current_date = Carbon::today()->toDateString();

                    foreach ($temparray as $item) {
                        $ordercount = Order::where('delivery_date', $request->inputDate)
                            ->where('delivery_time', $item)
                            ->count();
                            
                        if ($ordercount < helper::appdata()->perslot_booking_limit) {
                            $slot_parts = explode(' - ', $item);
                            if ($input_date === $current_date) {
                                if ($currenttime < date('H:i', strtotime($slot_parts[0]))) {
                                    $slots[] = $item; // Directly add string to array
                                }
                            } else {
                                $slots[] = $item; // Directly add string to array
                            }
                        }
                    }
                }
            }
            
            // Return as JSON response with proper structure
            return response()->json([
                'status' => true,
                'message' => 'Time slots retrieved successfully',
                'date' => $request->inputDate,
                'slots' => $slots,
                'is_closed' => !empty($slots) && $slots[0] === "closed"
            ]);
            
        } catch (\Throwable $th) {
            Log::error('Timeslot error: ' . $th->getMessage());
            
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch time slots',
                'slots' => [],
                'error' => config('app.debug') ? $th->getMessage() : null
            ], 500);
        }
    }

    public function paymentsuccess($id)
    {
        try {

            $order = Order::findOrFail($id);

            $authUser = auth('sanctum')->user();
            if ($authUser && $order->user_id && (int) $order->user_id !== (int) $authUser->id) {
                return response()->json(['status' => 0, 'msg' => 'Order not found'], 404);
            }

            if ((int) $order->payment_status !== 2) {
                if (!$order->stripe_payment_intent_id) {
                    return response()->json(['status' => 0, 'msg' => 'Payment cannot be verified'], 422);
                }

                $stripeKey = helper::branch_stripe_data($order->branch_id);
                if (!$stripeKey) {
                    return response()->json(['status' => 0, 'msg' => 'Payment cannot be verified'], 422);
                }

                \Stripe\Stripe::setApiKey($stripeKey->secret_key);
                $paymentIntent = \Stripe\PaymentIntent::retrieve($order->stripe_payment_intent_id);

                if ($paymentIntent->status !== 'succeeded') {
                    return response()->json(['status' => 0, 'msg' => 'Payment has not been completed'], 422);
                }
            }

            DB::transaction(function () use ($id) {

                $order = Order::findOrFail($id);

                if ($order->payment_status === 2) {
                    return;
                }

                if ($order->user_id) {
                    $user = User::findOrFail($order->user_id);
                    $settings = Settings::first();

                    $points = 0;

                    if ($settings && $settings->point_per_dollar > 0) {
                        $points = floor($order->grand_total / $settings->point_per_dollar);
                    }

                    if ($points > 0) {
                        $user->increment('wallet', $points);
                    }
                }

                $order->payment_status = 2;
                $order->save();

                $this->createPrintJob($order->id, $order->branch_id);
            });

            return response()->json([
                'status' => 1,
                'msg' => 'Payment successful'
            ]);

        } catch (\Throwable $e) {

            Log::error('Payment success failed', [
                'order_id' => $id,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 0,
                'msg' => 'Payment processing failed'
            ], 500);
        }
    }

    public function paymentfail()
    {
        return response()->json(['status' => 0, 'msg' => 'Payment failed']);

    }

    public function reOrder(Request $request, $orderId)
    {
        try {
            $user = auth('sanctum')->user();
            $branchId = $request->branch_id;

            // 🔒 Only logged-in users
            if (!$user || $user->type != 2) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }

            // Fetch order
            $order = Order::with('orderDetails')
                ->where('id', $orderId)
                ->where('user_id', $user->id)
                ->first();

            

            if (!$order) {
                return response()->json([
                    'status' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            if (!$order->branch_id || $order->branch_id != $branchId) {
                return response()->json([
                    'status' => false,
                    'message' => 'this Order belongs to Different Branch'
                ], 404);
            }

            // Optional: clear existing cart
            Cart::where('user_id', $user->id)->delete();

            foreach ($order->orderDetails as $item) {

                $cart = new Cart();
                $cart->user_id = $user->id;
                $cart->item_id = $item->item_id;
                $cart->deal_id = $item->deal_id;
                $cart->custom_pizza_id = $item->custom_pizza_id;
                $cart->item_name = $item->item_name;
                $cart->item_type = $item->item_type;
                $cart->item_image = $item->item_image;
                $cart->crust_id = $item->crust_id;
                $cart->size_id = $item->size_id;
                $cart->dipping_quantity = $item->dipping_quantity;
                $cart->dipping_name = $item->dipping_name;
                $cart->dipping_price = $item->dipping_price;
                $cart->tax = $item->tax;
                $cart->qty = $item->qty;
                $cart->item_price = $item->item_price;

                $cart->addons_id = $item->addons_id;
                $cart->addons_name = $item->addons_name;
                $cart->addons_price = $item->addons_price;
                $cart->addons_total_price = $item->addons_total_price;

                $cart->extras_id = $item->extras_id;
                $cart->extras_name = $item->extras_name;
                $cart->extras_price = $item->extras_price;
                $cart->extras_total_price = $item->extras_total_price;

                $cart->save();
            }

            return response()->json([
                'status' => true,
                'message' => 'Items added to cart successfully',
            ]);

        } catch (\Throwable $th) {
            Log::error('Reorder failed: ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Failed to reorder'
            ], 500);
        }
    }
}
