<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\helper;
use App\Helpers\sms_helper;
use App\Helpers\whatsapp_helper;
use App\Models\CustomStatus;
use App\Services\StarCloudPrinterService;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use App\Models\OrderDetails;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user= auth()->user();
        // Start the query for orders
        $getorders = Order::with('user_info', 'branch');
   

    if ($user->branch_id !== null) {
        $getorders = $getorders->where(function ($query) use ($user) {
            $query->where('branch_id', $user->branch_id)
                  ->whereDate('created_at', '>=', now()->subDays(2)); // Fetch today + last 2 days
        });
    }
    $getorders= $getorders->where(function ($query) {
        $query->where('transaction_type', 15)
              ->where('payment_status', 2);
    })
    ->orWhere(function ($query) {
        $query->where('transaction_type', '!=', 15);
    });
        // Apply status filter
        if ($request->has('status') && $request->status != "") {
            if ($request->status == "processing") {
                $getorders->whereIn('status_type', [1, 2]);
            } elseif ($request->status == "completed") {
                $getorders->where('status_type', 3);
            } elseif ($request->status == "cancelled") {
                $getorders->where('status_type', 4);
            }
        }
        $getorders = $getorders->orderByDesc('id')->get()->groupBy('branch_id') // Group orders by branch_id
        ->map(function ($orders, $branchId) {
            return [
                'branch_name' => $orders->first()->branch->name ?? 'Unknown', // Get branch name or default to 'Unknown'
                'orders' => $orders->map(function ($order) {
                    return [
                        'id' => $order->id,
                        'user_name' => $order->name, // Adjust as per your relationship
                        'status' => $order->status,
                        'status_type' => $order->status_type,
                        'admin_notes' => $order->admin_notes,
                        'order_number' => $order->order_number,
                        'grand_total' => $order->grand_total,
                        'order_type' => $order->order_type,
                        'tip' => $order->tip,
                        'transaction_type' => $order->transaction_type,
                        'payment_status' => $order->payment_status,
                        'created_at' => $order->created_at->format('Y-m-d H:i:s'),
                    ];
                }),
            ];
        })
            ->values();
        // Filter orders by branch (assuming 'branch_id' is the column for branch filtering)
        if ($request->has('branch_id') && $request->branch_id != "") {
            $getorders = $getorders->where('branch_id', $request->branch_id);  // Adjust the column name if it's different
        }

        // Filter orders based on status type
        $branchId = $user->branch_id ?? $request->branch_id; // Use user branch_id if available, otherwise request branch_id


        // Retrieve orders with the necessary sorting
        // Get available drivers for the branch (assuming 'branch_id' for filtering drivers by branch)
        $getdriver = User::where('type', '3')->where('is_available', 1)
            ->orderByDesc('id')
            ->get();

        // Get order counts for each status per branch
        $totalprocessing = Order::whereIn('status_type', [1, 2])->where(function ($query) {
            $query->where('transaction_type', 15)
                ->where('payment_status', 2); // Ensure paid status for type 15
        })->orWhere(function ($query) {
            $query->whereNot('transaction_type', 15); // Fetch all other payment types without checking status
        })
            ->where('order_from', '!=', 'pos')
            ->when($branchId, function ($query, $branchId) {
                return $query->where('branch_id', $branchId);  // Apply branch_id filter if $branchId is available
            })
            ->count();
        // Shared conditions for transaction_type and payment_status filtering
        $transactionFilter = function ($query) {
            $query->where(function ($query) {
                $query->where('transaction_type', 15)
                    ->where('payment_status', 2);  // Ensure paid status for type 15
            })->orWhere(function ($query) {
                $query->whereNot('transaction_type', 15);  // Fetch all other payment types without checking status
            });
        };

        // For total completed orders
        $totalcompleted = Order::where('status_type', 3)
            ->where('order_from', '!=', 'pos')
            ->where($transactionFilter)  // Apply shared transaction filter
            ->when($branchId, function ($query, $branchId) {
                return $query->where('branch_id', $branchId);  // Apply branch filter if available
            })
            ->count();

        // For total cancelled orders
        $totalcancelled = Order::where('status_type', 4)
            ->where('order_from', '!=', 'pos')
            ->where($transactionFilter)  // Apply shared transaction filter
            ->when($branchId, function ($query, $branchId) {
                return $query->where('branch_id', $branchId);  // Apply branch filter if available
            })
            ->count();

        // For total orders (all statuses)
        $total = Order::where($transactionFilter)  // Apply shared transaction filter
        ->when($branchId, function ($query, $branchId) {
            return $query->where('branch_id', $branchId);  // Apply branch filter if available
        })
            ->count();


        // Pass the data to the view
        return view('admin.orders.index', compact('getorders', 'getdriver', 'totalprocessing','total', 'totalcompleted', 'totalcancelled'));
    }

    public function update(Request $request)
    {
        $orderdata = Order::find($request->id);
        $user_info = User::find($orderdata->user_id);

        $title = "";
        $message_text = "";
        $body = "";

        if ($request->statustype == "2") {
            $title = @helper::gettype($request->status, $request->statustype, $orderdata->order_type)->name;
            $body = 'Your Order ' . $orderdata->order_number . ' has been accepted by Admin';
            $message_text = 'Your Order ' . $orderdata->order_number . ' has been accepted by Admin';
        }
        if ($request->statustype == "3") {
            $title = @helper::gettype($request->status, $request->statustype, $orderdata->order_type)->name;
            $body = 'Your Order ' . $orderdata->order_number . ' is ready now.';
            $message_text = 'Your Order ' . $orderdata->order_number . ' has been successfully delivered.';
        }
        if ($request->statustype == "4") {
            $title = @helper::gettype($request->status, $request->statustype, $orderdata->order_type)->name;
            $body = 'Order ' . $orderdata->order_number . ' has been cancelled by Admin.';
            $message_text = 'Order ' . $orderdata->order_number . ' has been cancelled by Admin.';
        }
        if ($request->statustype == "4") {
            // order cancelled by admin
            $title = trans('labels.order_cancelled');
            $body = 'Order ' . $orderdata->order_number . ' has been cancelled.';
            $message_text = 'Order ' . $orderdata->order_number . ' has been cancelled.';

            if ($orderdata->user_id != null) {
                if ($orderdata->transaction_type != 1) {
                    if ($orderdata->user_id != null) {
                        $user_info->wallet += $orderdata->grand_total;
                    }
                    $transaction = new Transaction;
                    $transaction->user_id = $orderdata->user_id;
                    $transaction->order_id = $orderdata->id;
                    $transaction->order_number = $orderdata->order_number;
                    $transaction->amount = $orderdata->grand_total;
                    $transaction->transaction_id = $orderdata->transaction_id;
                    $transaction->transaction_type = '2';

                    if ($transaction->save()) {
                        $user_info->save();
                    }
                }
            }
        }

        if ($orderdata->user_id != null) {
            if ($user_info->is_notification == 1) {
                $noti = helper::push_notification($user_info->token, $title, $body, "order", $orderdata->id);
            }

            if ($user_info->is_mail == 1) {
                if (@helper::checkaddons('otp')) {

                    $status_sms = sms_helper::order_status_sms($user_info->mobile, $user_info->name, $title, $message_text);
                } else {
                    $status_email = helper::order_status_email($user_info->email, $user_info->name, $title, $message_text);
                }
            }
        }

        $defaultsatus = CustomStatus::where('order_type', $orderdata->order_type)->where('type', $request->statustype)->where('id', $request->status)->where('is_available', 1)->where('is_deleted', 2)->first();
        $orderdata->status = $defaultsatus->id;
        $orderdata->status_type = $defaultsatus->type;

        if (@helper::checkaddons('whatsapp_message')) {
            if (whatsapp_helper::whatsapp_message_config()->status_change == 1) {
                whatsapp_helper::orderupdatemessage($orderdata->order_number, $title);
            }
        }

        if ($orderdata->save()) {
            return 1;
        } else {
            return 0;
        }
    }

    public function assign_driver(Request $request)
    {
        $orderdata = Order::find($request->order_id);
        $user_info = User::find($orderdata->user_id);
        $driver_info = User::find($request->driver_id);
        // for user
        if ($orderdata->user_id != null) {
            $title = trans('messages.driver_assigned_title');
            $body = 'Delivery boy' . $driver_info->name . ' has been assigned to your Order ' . $orderdata->order_number;
            $message_text = 'Delivery boy ' . $driver_info->name . ' has been assigned to your Order ' . $orderdata->order_number;
            $noti = helper::push_notification($user_info->token, $title, $body, "order", $orderdata->id);

            if (@helper::checkaddons('otp')) {
                $status_sms = sms_helper::order_status_sms($user_info->email, $user_info->name, $title, $message_text);
            } else {
                $status_email = helper::order_status_email($user_info->email, $user_info->name, $title, $message_text);
            }
        }


        // for driver
        $title = trans('messages.new_order_assigned_title');
        $body = 'New Order ' . $orderdata->order_number . ' assigned to you';
        $message_text = 'New order ' . $orderdata->order_number . ' has been assigned to you.';
        $noti = helper::push_notification($driver_info->token, $title, $body, "order", $orderdata->id);


        $status_email = helper::order_status_email($driver_info->email, $driver_info->name, $title, $message_text);


        $orderdata->driver_id = $request->driver_id;
        $orderdata->save();

        if (@helper::checkaddons('whatsapp_message')) {
            if (whatsapp_helper::whatsapp_message_config()->status_change == 1) {
                whatsapp_helper::orderupdatemessage($orderdata->order_number, trans('messages.driver_assigned_title'));
            }
        }
        return response()->json(['status' => 1, "message" => trans('messages.success')], 200);
    }
    public function invoice(Request $request)
    {
        $od = Order::where('id', $request->id)->first();
        $orderdata = Order::with('user_info', 'driver_info')->where('order.id', $request->id)->first();
        $ordersdetails = OrderDetails::where('order_details.order_id', $request->id)
            ->where('custom_pizza_id',null)
            ->with('size','crust')
            ->get();
        $orderCustomdetails = OrderDetails::where('order_details.order_id', $request->id)
            ->whereNotNull('custom_pizza_id')
            ->with('custom_pizza.toppings', 'custom_pizza.size', 'custom_pizza.crust', 'custom_pizza.sauce', 'custom_pizza.dipping')
            ->get();

        return view('admin.orders.invoice', compact('orderdata', 'ordersdetails','orderCustomdetails'));
    }
    public function print(Request $request)
    {
        $orderdata = Order::with('user_info', 'driver_info')->where('order.id', $request->id)->first();
        $ordersdetails = OrderDetails::where('order_details.order_id', $request->id)->get();
        // return view('admin.orders.printInvoice', compact('orderdata', 'ordersdetails'));
        return view('admin.orders.printInvoice', compact('orderdata', 'ordersdetails'));

    }
    public function generatepdf(Request $request)
    {
        // $printerService = new StarCloudPrinterService();
        // $printerService->printJob($request->id);

        $getorderdata = Order::with('user_info', 'driver_info')->where('order.id', $request->id)->first();
        $ordersdetails =  OrderDetails::where('order_details.order_id', $request->id)->get();
        $pdf = Pdf::loadView('admin.orders.invoicepdf', ['getorderdata' => $getorderdata, 'ordersdetails' => $ordersdetails]);
        return $pdf->download('orderinvoice.pdf');

    }
    public function order_note(Request $request)
    {
        $updatenote = Order::where('order_number', $request->order_id)->first();
        $updatenote->admin_notes = $request->admin_notes;
        $updatenote->update();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function customerbillinfo(Request $request)
    {
        $customerinfo = Order::where('order_number', $request->order_id)->first();
        if ($request->edit_type == "customer_info") {
            $customerinfo->name = $request->user_name;
            $customerinfo->mobile = $request->user_mobile;
            $customerinfo->email = $request->user_email;
        }
        if ($request->edit_type == "bill_info") {
            $customerinfo->address = $request->bill_address;
            $customerinfo->city = $request->bill_city;
            $customerinfo->state = $request->bill_state;
            $customerinfo->country = $request->bill_country;
            $customerinfo->landmark = $request->bill_landmark;
            $customerinfo->postal_code = $request->bill_pincode;
        }
        $customerinfo->update();
        return redirect()->back()->with('success', trans('messages.success'));
    }

    public function get_reports(Request $request)
    {
        $getorders = array();
        $totalprocessing = 0;
        $totalcompleted = 0;
        $totalcancelled = 0;
        $totalearnings = 0;
        $totalrevenue = 0;
        if (!empty($request->startdate) && !empty($request->enddate)) {
            $getorders = Order::with('user_info', 'driver_info')->select('order.*')
                ->whereBetween('order.created_at', [$request->startdate, $request->enddate])
                ->orderByDesc('id')->where('branch_id',$request->branch_id)
                ->get();
            $totalprocessing = Order::whereNotIn('status', array(5, 6, 7))->whereBetween('created_at', [$request->startdate, $request->enddate])->where('branch_id',$request->branch_id)->count();
            $totalcompleted = Order::where('status', 5)->whereBetween('created_at', [$request->startdate, $request->enddate])->where('branch_id',$request->branch_id)->count();
            $totalcancelled = Order::whereIn('status', array(6, 7))->whereBetween('created_at', [$request->startdate, $request->enddate])->where('branch_id',$request->branch_id)->count();
            $totalearnings = Order::where('status', 5)->whereBetween('created_at', [$request->startdate, $request->enddate])->where('branch_id',$request->branch_id)->sum('grand_total');
        }
        $getdriver = User::where('is_available', '1')->where('type', '3')->get();
        $total = $totalprocessing + $totalcompleted + $totalcancelled;
        return view('admin.orders.report', compact('getorders', 'getdriver', 'totalprocessing', 'totalcompleted', 'totalcancelled', 'totalearnings', 'total'));
    }

    public function payment_status(Request $request)
    {
        date_default_timezone_set(@helper::appdata()->timezone);
        if ($request->ramin_amount > 0) {
            return redirect()->back()->with('error', trans('messages.amount_validation_msg'));
        }
        $order = Order::where('order_number', $request->booking_number)->first();
        $order->payment_status = 2;
        $order->update();
        return redirect()->back()->with('success', trans('messages.success'));
    }

    public function deleteOrder($id)
    {
        $order = Order::where('id',$id)->first();
        $order->delete();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    
    public function deleteUnpaidPreBookings()
    {

        $deletedOrders = Order::where('transaction_type', 15)
            ->where('payment_status', '!=', 2) // Unpaid prebookings
            ->delete();
    
        return response()->json(['message'=>'deleted successfully']);
    }
}
