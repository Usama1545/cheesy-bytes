<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\ValidatesImageUploads;
use App\Models\PrintJob;
use App\Services\OrderPrintEligibility;
use Illuminate\Http\Request;
use App\Helpers\helper;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Models\Branch;
use App\Models\Addons;
use App\Models\Ratting;
use App\Models\OrderDetails;
use App\Models\Banner;
use App\Models\Order;
use App\Models\Promocode;
use App\Models\Settings;
use App\Models\Time;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Session;
use Illuminate\Console\Command;
use Barryvdh\DomPDF\Facade\Pdf;


class AdminController extends Controller
{
    use ValidatesImageUploads;

    public function home(Request $request)
    {
        $ordersbranch = $request->ordersbranch != "" ? $request->ordersbranch : Branch::first()->id;

        $gettotalcategory = Category::where('is_available', '1')->where('is_deleted', '2')->count();
        $getitems = Item::where('item_status', '1')->get();
        $addons = Addons::where('is_available', '1')->where('is_deleted', '2')->get();
        $getpromocode = Promocode::where('is_available', 1)->get();
        $getusers = User::Where('type', '=', '2')->get();
        $getdriver = User::where('is_available', '1')->where('type', '3')->get();
        $getreview = Ratting::all();
        $getorders = Order::where('order_from', '=' , 'web')->where(function ($query) {
            $query->where('transaction_type', 15)
                ->where('payment_status', 2); // Ensure paid status for type 15
        })->orWhere(function ($query) {
            $query->whereNot('transaction_type', 15); // Fetch all other payment types without checking status
        })->get();

        $getorderscount = Order::where('order_from', '=' , 'web')->where(function ($query) {
            $query->where('transaction_type', 15)
                ->where('payment_status', 2); // Ensure paid status for type 15
        })->orWhere(function ($query) {
            $query->whereNot('transaction_type', 15); // Fetch all other payment types without checking status
        })->count();
        $getorderdetailscount = OrderDetails::all();
        $banners = Banner::all();
        $order_total = Order::where('order_from', '=' , 'web')->where(function ($query) {
            $query->where('transaction_type', 15)
                ->where('payment_status', 2); // Ensure paid status for type 15
        })->orWhere(function ($query) {
            $query->whereNot('transaction_type', 15); // Fetch all other payment types without checking status
        })->where('status', '!=', '6')->where('status', '!=', '7')->sum('grand_total');
        $order_tax = Order::where('order_from', '=' , 'web')->where(function ($query) {
            $query->where('transaction_type', 15)
                ->where('payment_status', 2); // Ensure paid status for type 15
        })->orWhere(function ($query) {
            $query->whereNot('transaction_type', 15); // Fetch all other payment types without checking status
        })->where('status', '!=', '6')->where('status', '!=', '7')->sum('tax_amount');
        $getbranchorders = Order::where('order_from', '=' , 'web')->with('user_info', 'branch')->whereDate('created_at', Carbon::today())
            ->where(function ($query) {
                $query->where('transaction_type', 15)
                    ->where('payment_status', 2); // Ensure paid status for type 15
            })->orWhere(function ($query) {
                $query->whereNot('transaction_type', 15); // Fetch all other payment types without checking status
            })->select('order.*') // Correct table name for consistency
            ->get()
            ->groupBy('branch_id') // Group orders by branch_id
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
                            'transaction_type' => $order->transaction_type,
                            'payment_status' => $order->payment_status,
                            'created_at' => $order->created_at->format('Y-m-d H:i:s'),
                        ];
                    }),
                ];
            })
            ->values();
        $topitems = Item::with('category_info', 'subcategory_info', 'item_image')
            ->leftJoin('order_details', 'order_details.item_id', 'item.id')
            ->leftJoin('order', 'order.id', 'order_details.order_id')
            ->where('order.order_from', 'web')
            ->whereNull('order_details.custom_pizza_id')
            ->select(
                'item.id',
                'item.cat_id',
                'item.subcat_id',
                'item.item_name',
                'item.slug',
                DB::raw('COUNT(order_details.item_id) as item_order_counter')
            )
            ->where('item.item_status', '1')
            ->groupBy('item.id')
            ->having('item_order_counter', '>', 0)
            ->orderByDesc('item_order_counter')
            ->limit(7)
            ->get();

        $topusers = User::leftJoin('order', 'order.user_id', 'users.id')
            ->where('order.order_from', 'web')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.mobile',
                'users.profile_image',
                DB::raw('COUNT(order.id) as user_order_counter')
            )
            ->where('users.type', '2')
            ->where('users.is_available', '1')
            ->groupBy('users.id')
            ->having('user_order_counter', '>', 0)
            ->orderByDesc('user_order_counter')
            ->limit(5)
            ->get();


        // ORDER-CHART-START
        $year = $request->getyear != "" ? $request->getyear : date('Y');
        $order_years = Order::where('order_from', '=' , 'web')->select(DB::raw("YEAR(created_at) as year"))->groupBy(DB::raw("YEAR(created_at)"))->where(function ($query) {
            $query->where('transaction_type', 15)
                ->where('payment_status', 2); // Ensure paid status for type 15
        })->orWhere(function ($query) {
            $query->whereNot('transaction_type', 15); // Fetch all other payment types without checking status
        })->orderByDesc('created_at')->get();
        $orderlabels = Order::where('order_from', '=' , 'web')->select(DB::raw("MONTHNAME(created_at) as month_name"))->whereYear('created_at', $year)->where(function ($query) {
            $query->where('transaction_type', 15)
                ->where('payment_status', 2); // Ensure paid status for type 15
        })->orWhere(function ($query) {
            $query->whereNot('transaction_type', 15); // Fetch all other payment types without checking status
        })->orderBy('created_at')->groupBy(DB::raw("MONTHNAME(created_at)"))->pluck('month_name');
        $deliverydata = $pickupdata = array();
        foreach ($orderlabels as $monthname) {
            $deliverydata[] = Order::where('order_from', '=' , 'web')->whereYear('created_at', $year)->where('order_type', 1)->where(function ($query) {
                $query->where('transaction_type', 15)
                    ->where('payment_status', 2); // Ensure paid status for type 15
            })->orWhere(function ($query) {
                $query->whereNot('transaction_type', 15); // Fetch all other payment types without checking status
            })->orderBy('created_at')->where(DB::raw("MONTHNAME(created_at)"), $monthname)->count();
            $pickupdata[] = Order::where('order_from', '=' , 'web')->whereYear('created_at', $year)->where('order_type', 2)->where(function ($query) {
                $query->where('transaction_type', 15)
                    ->where('payment_status', 2); // Ensure paid status for type 15
            })->orWhere(function ($query) {
                $query->whereNot('transaction_type', 15); // Fetch all other payment types without checking status
            })->orderBy('created_at')->where(DB::raw("MONTHNAME(created_at)"), $monthname)->count();
        }
        // ORDER-CHART-END


        // USERS-CHART-START
        $useryear = $request->useryear != "" ? $request->useryear : date('Y');
        $user_years = User::select(DB::raw("YEAR(created_at) as year"))->groupBy(DB::raw("YEAR(created_at)"))->orderByDesc('created_at')->get();
        $userslist = User::select(DB::raw("YEAR(created_at) as year"), DB::raw("MONTHNAME(created_at) as month_name"), DB::raw("COUNT(id) as total_user"))
            ->whereYear('created_at', $useryear)
            ->where('type', 2)
            ->orderBy('created_at')
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('total_user', 'month_name');
        $userslabels = $userslist->keys();
        $userdata = $userslist->values();
        // USERS-CHART-END

        // EARNINGS-CHART-START
        $earningsyear = $request->earningsyear != "" ? $request->earningsyear : date('Y');
        $earningsbranch = $request->earningsbranch != "" ? $request->earningsbranch : Branch::first()->id;
        $earnings_years = Order::where('order_from', '=' , 'web')->select(DB::raw("YEAR(created_at) as year"))->where(function ($query) {
            $query->where('transaction_type', 15)
                ->where('payment_status', 2); // Ensure paid status for type 15
        })->orWhere(function ($query) {
            $query->whereNot('transaction_type', 15); // Fetch all other payment types without checking status
        })->groupBy(DB::raw("YEAR(created_at)"))->orderByDesc('created_at')->get();
        $reviewslist = Order::where('order_from', '=' , 'web')->select(DB::raw("YEAR(created_at) as year"), DB::raw("MONTHNAME(created_at) as month_name"), DB::raw("SUM(grand_total) as grand_total"))
            ->whereYear('created_at', $earningsyear)
            ->where(function ($query) {
                $query->where('transaction_type', 15)
                    ->where('payment_status', 2); // Ensure paid status for type 15
            })->orWhere(function ($query) {
                $query->whereNot('transaction_type', 15); // Fetch all other payment types without checking status
            })->where('branch_id', $earningsbranch)
            ->whereNotIn('status', array(1, 6, 7))
            ->orderBy('created_at')
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('grand_total', 'month_name');
        $earningslabels = $reviewslist->keys();
        $earningsdata = $reviewslist->values();
        // EARNINGS-CHART-END

        if (env('Environment') == 'sendbox') {
            $userslabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];
            $userdata = [636, 1269, 2810, 2843, 3637, 467, 902, 1296, 402, 1173, 1509, 413];
            $earningslabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];
            $earningsdata = [636, 1269, 2810, 2843, 2545, 467, 902, 1296, 402, 1173, 1509, 2000];
            $orderlabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];
            $deliverydata = [285, 830, 550, 881, 130, 194, 213, 525, 245, 348, 581, 459];
            $pickupdata = [105, 343, 394, 299, 636, 984, 492, 135, 287, 250, 509, 121];
        }

        if ($request->ajax()) {
            return response()->json(['orderlabels' => $orderlabels, 'deliverydata' => $deliverydata, 'pickupdata' => $pickupdata, 'userslabels' => $userslabels, 'userdata' => $userdata, 'earningslabels' => $earningslabels, 'earningsdata' => $earningsdata], 200);
        } else {
            return view('admin.dashboard.home', compact('topitems', 'topusers', 'gettotalcategory', 'getitems', 'addons', 'getusers', 'banners', 'getreview', 'getorderscount', 'getorderdetailscount', 'order_total', 'order_tax', 'getpromocode', 'getbranchorders', 'getdriver', 'order_years', 'orderlabels', 'deliverydata', 'pickupdata', 'user_years', 'userslabels', 'userdata', 'earnings_years', 'earningslabels', 'earningsdata'));
        }
    }

    public function mobileHome(Request $request)
    {
        $ordersbranch = $request->ordersbranch != "" ? $request->ordersbranch : Branch::first()->id;

        $gettotalcategory = Category::where('is_available', '1')->where('is_deleted', '2')->count();
        $getitems = Item::where('item_status', '1')->get();
        $addons = Addons::where('is_available', '1')->where('is_deleted', '2')->get();
        $getpromocode = Promocode::where('is_available', 1)->get();
        $getusers = User::Where('type', '=', '2')->where('is_app_user', 1)->get();
        $getdriver = User::where('is_available', '1')->where('type', '3')->get();
        $getreview = Ratting::all();
        $getorders = Order::where('order_from', '=' , 'api')->where(function ($query) {
            $query->where('transaction_type', 15)
                ->where('payment_status', 2); // Ensure paid status for type 15
        })->orWhere(function ($query) {
            $query->whereNot('transaction_type', 15); // Fetch all other payment types without checking status
        })->get();

        $getorderscount = Order::where('order_from', '=' , 'api')->where(function ($query) {
            $query->where('transaction_type', 15)
                ->where('payment_status', 2); // Ensure paid status for type 15
        })->orWhere(function ($query) {
            $query->whereNot('transaction_type', 15); // Fetch all other payment types without checking status
        })->count();
        $getorderdetailscount = OrderDetails::all();
        $banners = Banner::all();
        $order_total = Order::where('order_from', '=' , 'api')->where(function ($query) {
            $query->where('transaction_type', 15)
                ->where('payment_status', 2); // Ensure paid status for type 15
        })->orWhere(function ($query) {
            $query->whereNot('transaction_type', 15); // Fetch all other payment types without checking status
        })->where('status', '!=', '6')->where('status', '!=', '7')->sum('grand_total');
        $order_tax = Order::where('order_from', '=' , 'api')->where(function ($query) {
            $query->where('transaction_type', 15)
                ->where('payment_status', 2); // Ensure paid status for type 15
        })->orWhere(function ($query) {
            $query->whereNot('transaction_type', 15); // Fetch all other payment types without checking status
        })->where('status', '!=', '6')->where('status', '!=', '7')->sum('tax_amount');
        $getbranchorders = Order::where('order_from', '=' , 'api')->with('user_info', 'branch')->whereDate('created_at', Carbon::today())
            ->where(function ($query) {
                $query->where('transaction_type', 15)
                    ->where('payment_status', 2); // Ensure paid status for type 15
            })->orWhere(function ($query) {
                $query->whereNot('transaction_type', 15); // Fetch all other payment types without checking status
            })->select('order.*') // Correct table name for consistency
            ->get()
            ->groupBy('branch_id') // Group orders by branch_id
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
                            'transaction_type' => $order->transaction_type,
                            'payment_status' => $order->payment_status,
                            'created_at' => $order->created_at->format('Y-m-d H:i:s'),
                        ];
                    }),
                ];
            })
            ->values();
        $topitems = Item::with('category_info', 'subcategory_info', 'item_image')
            ->leftJoin('order_details', 'order_details.item_id', 'item.id')
            ->leftJoin('order', 'order.id', 'order_details.order_id')
            ->where('order.order_from', 'api')
            ->whereNull('order_details.custom_pizza_id')
            ->select(
                'item.id',
                'item.cat_id',
                'item.subcat_id',
                'item.item_name',
                'item.slug',
                DB::raw('COUNT(order_details.item_id) as item_order_counter')
            )
            ->where('item.item_status', '1')
            ->groupBy('item.id')
            ->having('item_order_counter', '>', 0)
            ->orderByDesc('item_order_counter')
            ->limit(7)
            ->get();

        $topusers = User::leftJoin('order', 'order.user_id', 'users.id')
            ->where('is_app_user', 1)
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.mobile',
                'users.profile_image',
                DB::raw('COUNT(order.id) as user_order_counter')
            )
            ->where('users.type', '2')
            ->where('users.is_available', '1')
            ->groupBy('users.id')
            ->having('user_order_counter', '>', 0)
            ->orderByDesc('user_order_counter')
            ->limit(5)
            ->get();


        // ORDER-CHART-START
        $year = $request->getyear != "" ? $request->getyear : date('Y');
        $order_years = Order::where('order_from', '=' , 'api')->select(DB::raw("YEAR(created_at) as year"))->groupBy(DB::raw("YEAR(created_at)"))->where(function ($query) {
            $query->where('transaction_type', 15)
                ->where('payment_status', 2); // Ensure paid status for type 15
        })->orWhere(function ($query) {
            $query->whereNot('transaction_type', 15); // Fetch all other payment types without checking status
        })->orderByDesc('created_at')->get();
        $orderlabels = Order::where('order_from', '=' , 'api')->select(DB::raw("MONTHNAME(created_at) as month_name"))->whereYear('created_at', $year)->where(function ($query) {
            $query->where('transaction_type', 15)
                ->where('payment_status', 2); // Ensure paid status for type 15
        })->orWhere(function ($query) {
            $query->whereNot('transaction_type', 15); // Fetch all other payment types without checking status
        })->orderBy('created_at')->groupBy(DB::raw("MONTHNAME(created_at)"))->pluck('month_name');
        $deliverydata = $pickupdata = array();
        foreach ($orderlabels as $monthname) {
            $deliverydata[] = Order::where('order_from', '=' , 'api')->whereYear('created_at', $year)->where('order_type', 1)->where(function ($query) {
                $query->where('transaction_type', 15)
                    ->where('payment_status', 2); // Ensure paid status for type 15
            })->orWhere(function ($query) {
                $query->whereNot('transaction_type', 15); // Fetch all other payment types without checking status
            })->orderBy('created_at')->where(DB::raw("MONTHNAME(created_at)"), $monthname)->count();
            $pickupdata[] = Order::where('order_from', '=' , 'api')->whereYear('created_at', $year)->where('order_type', 2)->where(function ($query) {
                $query->where('transaction_type', 15)
                    ->where('payment_status', 2); // Ensure paid status for type 15
            })->orWhere(function ($query) {
                $query->whereNot('transaction_type', 15); // Fetch all other payment types without checking status
            })->orderBy('created_at')->where(DB::raw("MONTHNAME(created_at)"), $monthname)->count();
        }
        // ORDER-CHART-END


        // USERS-CHART-START
        $useryear = $request->useryear != "" ? $request->useryear : date('Y');
        $user_years = User::select(DB::raw("YEAR(created_at) as year"))->groupBy(DB::raw("YEAR(created_at)"))->orderByDesc('created_at')->where('is_app_user', 1)->get();
        $userslist = User::select(DB::raw("YEAR(created_at) as year"), DB::raw("MONTHNAME(created_at) as month_name"), DB::raw("COUNT(id) as total_user"))
            ->whereYear('created_at', $useryear)
            ->where('is_app_user', 1)
            ->where('type', 2)
            ->orderBy('created_at')
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('total_user', 'month_name');
        $userslabels = $userslist->keys();
        $userdata = $userslist->values();
        // USERS-CHART-END

        // EARNINGS-CHART-START
        $earningsyear = $request->earningsyear != "" ? $request->earningsyear : date('Y');
        $earningsbranch = $request->earningsbranch != "" ? $request->earningsbranch : Branch::first()->id;
        $earnings_years = Order::where('order_from', '=' , 'api')->select(DB::raw("YEAR(created_at) as year"))->where(function ($query) {
            $query->where('transaction_type', 15)
                ->where('payment_status', 2); // Ensure paid status for type 15
        })->orWhere(function ($query) {
            $query->whereNot('transaction_type', 15); // Fetch all other payment types without checking status
        })->groupBy(DB::raw("YEAR(created_at)"))->orderByDesc('created_at')->get();
        $reviewslist = Order::where('order_from', 'api')
        ->whereYear('created_at', $earningsyear)
        ->where('transaction_type', 15)
        ->where('payment_status', 2) // only paid
        ->where('branch_id', $earningsbranch)
        ->select(
            DB::raw("MONTH(created_at) as month"),
            DB::raw("MONTHNAME(created_at) as month_name"),
            DB::raw("ROUND(SUM(grand_total), 2) as grand_total")
        )
        ->groupBy(DB::raw("MONTH(created_at)"))
        ->orderBy(DB::raw("MONTH(created_at)"))
        ->pluck('grand_total', 'month_name');
        

        $earningslabels = $reviewslist->keys();
         $earningsdata = $reviewslist->values();
        // EARNINGS-CHART-END
        if ($request->ajax()) {
            return response()->json(['orderlabels' => $orderlabels, 'deliverydata' => $deliverydata, 'pickupdata' => $pickupdata, 'userslabels' => $userslabels, 'userdata' => $userdata, 'earningslabels' => $earningslabels, 'earningsdata' => $earningsdata], 200);
        } else {
            return view('admin.dashboard.mobile-home', compact('topitems', 'topusers', 'gettotalcategory', 'getitems', 'addons', 'getusers', 'banners', 'getreview', 'getorderscount', 'getorderdetailscount', 'order_total', 'order_tax', 'getpromocode', 'getbranchorders', 'getdriver', 'order_years', 'orderlabels', 'deliverydata', 'pickupdata', 'user_years', 'userslabels', 'userdata', 'earnings_years', 'earningslabels', 'earningsdata'));
        }
    }

     public function getorder()
    {
        $user = auth()->user();
    
        $todayorders = Order::with('user_info')
            ->whereDate('created_at', Carbon::today());
    
        // If user belongs to a branch, filter by their branch_id
        if ($user->branch_id !== null) {
            $todayorders->where('branch_id', $user->branch_id);
        }
    
        // Filter orders: exclude unpaid prebookings
        $todayorders->where(function ($query) {
            $query->where('transaction_type', '!=', 15) // Include non-prebookings
                  ->orWhere(function ($subQuery) {
                      $subQuery->where('transaction_type', 15)
                               ->where('payment_status', 2); // Include only paid prebookings
                  });
        });
    
        $orderCount = $todayorders->count();
    
        $data = Settings::first();
        $noti = $data->notification_tune ?? null;


        return response()->json(['count' => 0, 'noti' => null]);
    }



    public function printOrders()
    {
        $printJobs = PrintJob::where('status', 'pending')
                            ->whereHas('order', function($query) {
                                OrderPrintEligibility::apply($query);
                            })
                            ->with('order.branch')
                            ->get();

        foreach ($printJobs as $job) {
            // Branches set to print via the desktop companion are printed
            // locally by that app instead of through PrintNode.
            if ($job->order && $job->order->branch && $job->order->branch->print_method === 'companion') {
                continue;
            }

            $this->printRecipt($job);
        }
    }
    
   public function printRecipt($job)
    {
        $order = $job->order;
        $printNodeApiKey =  $job->mac_id;

        $orderdata = Order::with('user_info', 'driver_info')->find( $job->order_id);
        $ordersdetails = OrderDetails::where('order_details.order_id', $job->order_id)
            ->where('custom_pizza_id',null)
            ->with('size','crust')
            ->get();
        $orderCustomdetails = OrderDetails::where('order_details.order_id', $job->order_id)
            ->whereNotNull('custom_pizza_id')
            ->with('custom_pizza.toppings', 'custom_pizza.size', 'custom_pizza.crust', 'custom_pizza.sauce', 'custom_pizza.dipping')
            ->get();

        $content = $this->formatContent($orderdata,$ordersdetails,$orderCustomdetails);
        $formattedText = nl2br(e($content));

        // Generate PDF with Dompdf
        $pdf = Pdf::loadHTML('<pre>' . $formattedText . '</pre>');

         $pdfPath = storage_path('app/public/invoice_' . $job->order_id . '.pdf');
         file_put_contents($pdfPath, $pdf->output());


        $printerId = $job->printer_id;

        if (!$printerId) {
            return response()->json(['error' => 'Printer not found'], 400);
        }
        $response = Http::timeout(40)
            ->retry(3, 2000)->withBasicAuth($printNodeApiKey, '')
            ->post('https://api.printnode.com/printjobs', [
                "printerId" => $printerId,
                "title" => "Order Receipt",
                "contentType" => "raw_base64",
                "content" => base64_encode($content),
                "source" => "CheesyBite App"
            ]);



        if ($response->failed()) {
            $job->update(['status' => 'failed']);
        } else {
            $job->update(['status' => 'printed']);
        }
    }
    private function centerText($text, $width)
    {
        $padding = max(0, floor(($width - strlen($text)) / 2));
        return str_repeat(' ', $padding) . $text;
    }
    public function formatContent($orderdata,$ordersdetails,$orderCustomdetails)
    {
        $order_total = 0;
        $qty = 0;
        $width = 20;

        // Start building the receipt
        $receipt = $this->centerText("CHEESY BITE", $width) . "\n";
        $receipt .= $this->centerText("Takeaway", $width) . "\n\n";

        $receipt .= $this->centerText("Name: {$orderdata->name}", $width) . "\n";
        $receipt .= $this->centerText("Email: {$orderdata->email}", $width) . "\n";
        $receipt .= $this->centerText("Mobile: {$orderdata->mobile}", $width) . "\n";
        $receipt .= $this->centerText("Address: {$orderdata->address}", $width) . "\n";
        $receipt .= $this->centerText("Order Number: {$orderdata->order_number}", $width) . "\n";
        $receipt .= $this->centerText("Order Date: " . date('M d, Y', strtotime($orderdata->created_at)), $width) . "\n";
        $receipt .= $this->centerText("Pickup Date: " . date('M d, Y', strtotime($orderdata->delivery_date)), $width) . "\n";
        $receipt .= $this->centerText("Pickup Time: {$orderdata->delivery_time}", $width) . "\n";
        $receipt .= $this->centerText("Pickup Location: {$orderdata->branch->name}", $width) . "\n\n";

        $receipt .= str_repeat("-", $width) . "\n";

        $receipt .= "#  Product Details";
        $receipt .= str_repeat("-", $width) . "\n";


        foreach ($ordersdetails as $key => $orders) {
            $line_total = ($orders->item_price + $orders->addons_total_price + $orders->extras_total_price) * $orders->qty;
            $order_total += $line_total;
            $qty += $orders->qty;

            $receipt .= ($key + 1) . ". {$orders->item_name}\n";

            if (!is_null($orders->size) && !is_null($orders->crust)) {
                $receipt .= "   ({$orders->size->name} - {$orders->crust->name})\n";
            }

            if (!empty($orders->addons_id) || !empty($orders->extras_id)) {
                $toppings = "";
                $addons = "";

                // Process Addons
                $addons_name = explode('| ', $orders->addons_name);
                $addons_price = explode('| ', $orders->addons_price);

                foreach ($addons_name as $index => $addon) {
                    if (trim($addon) === '') continue; // Skip empty values

                    $price = helper::currency_format($addons_price[$index]  ?? 0);
                    if (!isset($addons_price[$index]) || $addons_price[$index] == 0) {
                        $toppings .= "   - {$addon}: {$price}\n";
                    } else {
                        $addons .= "   - {$addon}: {$price}\n";
                    }
                }

                // Process Extras (Merged into Addons/Toppings)
                $extras_name = explode('| ', $orders->extras_name);
                $extras_price = explode('| ', $orders->extras_price);

                foreach ($extras_name as $index => $extra) {
                    if (trim($extra) === '' ) continue; // Skip empty values

                    $price = helper::currency_format($extras_price[$index] ?? 0);
                    if (!isset($extras_price[$index]) || $extras_price[$index] == 0) {
                        $toppings .= "   - {$extra}: {$price}\n";
                    } else {
                        $addons .= "   - {$extra}: {$price}\n";
                    }
                }

                // Append sections only if they have content
                if (!empty($toppings)) {
                    $receipt .= "   Toppings:\n" . $toppings;
                }
                if (!empty($addons)) {
                    $receipt .= "   Addons:\n" . $addons;
                }
            }



            $receipt .= "   Price: " . helper::currency_format($orders->item_price) . "\n";
            $receipt .= "   Category: " . $orders->items->category_info->category_name . "\n";
            $receipt .= "   Sub Category: " . ($orders->items->subcategory_info->subcategory_name ?? "") . "\n";

            $receipt .= "   Qty: {$orders->qty}\n";
            $receipt .= "   Line Total: " . helper::currency_format($line_total) . "\n";
            $receipt .= str_repeat("-", $width) . "\n";
        }

        foreach ($orderCustomdetails as $key => $orders) {
            $line_total = ($orders->item_price + $orders->addons_total_price + $orders->extras_total_price) * $orders->qty;
            $order_total += $line_total;
            $qty += $orders->qty;

            $receipt .= ($key + 1) . ". {$orders->item_name}\n";

            if (!is_null($orders->size) && !is_null($orders->crust)) {
                $receipt .= "   ({$orders->size->name} - {$orders->crust->name})\n";
            }

            if (!is_null($orders->custom_pizza)) {
                // Adding size, cut, bake, and seasoning details
                $receipt .= "   Size: {$orders->custom_pizza->size->name} ({$orders->custom_pizza->size->label})\n";
                // $receipt .= "   Special: {$orders->custom_pizza->cut} / {$orders->custom_pizza->bake} / {$orders->custom_pizza->seasoning}\n";
                $receipt .= "   Crust: {$orders->custom_pizza->crust->name}\n";
                // $receipt .= "   Sauce: {$orders->custom_pizza->sauce->name}\n";

                // Adding Toppings details
                if (isset($orders->custom_pizza->toppings)) {
                    $receipt .= "   Toppings:\n";
                    foreach ($orders->custom_pizza->toppings as $topping) {
                        $receipt .= "   - {$topping->name} ({$topping->pivot->side}) x {$topping->pivot->quantity}\n";
                    }
                }

                if (isset($orders->custom_pizza->sauces)) {
                    $receipt .= "   Extra Toppings:\n";
                    foreach ($orders->custom_pizza->sauces as $topping) {
                        $receipt .= "   - {$topping->name} ({$topping->pivot->side}) x {$topping->pivot->quantity}\n";
                    }
                }

                // Adding Dipping details
                if (isset($orders->custom_pizza->dipping)) {
                    $receipt .= "   Dipping:\n";
                    foreach ($orders->custom_pizza->dipping as $dipping) {
                        $receipt .= "   - {$dipping->name} x {$dipping->pivot->quantity} @ " . helper::currency_format($dipping->price) . " each\n";
                    }
                }
            }

            // Addons
            if (!empty($orders->addons_id) || !empty($orders->extras_id)) {
                $toppings = "";
                $addons = "";

                // Process Addons
                $addons_name = explode('| ', $orders->addons_name);
                $addons_price = explode('| ', $orders->addons_price);

                foreach ($addons_name as $index => $addon) {
                    if (trim($addon) === '') continue; // Skip empty values

                    $price = helper::currency_format($addons_price[$index]  ?? 0);
                    if (!isset($addons_price[$index]) || $addons_price[$index] == 0) {
                        $toppings .= "   - {$addon}: {$price}\n";
                    } else {
                        $addons .= "   - {$addon}: {$price}\n";
                    }
                }

                // Process Extras (Merged into Addons/Toppings)
                $extras_name = explode('| ', $orders->extras_name);
                $extras_price = explode('| ', $orders->extras_price);

                foreach ($extras_name as $index => $extra) {
                    if (trim($extra) === '') continue; // Skip empty values

                    $price = helper::currency_format($extras_price[$index]  ?? 0);
                    if (!isset($extras_price[$index]) || $extras_price[$index] == 0) {
                        $toppings .= "   - {$extra}: {$price}\n";
                    } else {
                        $addons .= "   - {$extra}: {$price}\n";
                    }
                }

                // Append sections only if they have content
                if (!empty($toppings)) {
                    $receipt .= "   Toppings:\n" . $toppings;
                }
                if (!empty($addons)) {
                    $receipt .= "   Addons:\n" . $addons;
                }
            }



            $receipt .= "   Price: " . helper::currency_format($orders->item_price) . "\n";
            $receipt .= "   Category: Custom Pizza \n";

            $receipt .= "   Qty: {$orders->qty}\n";
            $receipt .= "   Line Total: " . helper::currency_format($line_total) . "\n";
            $receipt .= str_repeat("-", $width) . "\n";
        }
        $receipt .= str_repeat("-", $width) . "\n";
        $receipt .= "Customer Note: " . $orderdata->order_notes . "\n";
        $receipt .= str_repeat("-", $width) . "\n";


        $discount = $orderdata->discount_amount ?? 0;
        $receipt .= "Subtotal: " . helper::currency_format($order_total) . "\n";
        $receipt .= "Discount: " . helper::currency_format($discount) . "\n";
        $tax = explode('|', $orderdata->tax_amount);
        $tax_name = explode('|', $orderdata->tax_name);
        if ($orderdata->tax_amount != null && $orderdata->tax_name != null) {
            foreach ($tax as $key => $tax_value) {
                $receipt .= $tax_name[$key] . " =" .helper::currency_format($tax_value) ;

            }
        }

        $receipt .= "Tip: " . helper::currency_format($orderdata->tip) . "\n";
        $receipt .= "Total Amount: " . helper::currency_format($orderdata->grand_total) . "\n";
    

        $receipt .= str_repeat("-", $width) . "\n";
        $receipt .= "Thank you for your order!\n";
        $receipt .= str_repeat("-", $width) . "\n";
        return $receipt;
    }
    public function login()
    {
        return view('login');
    }
    public function check_admin(Request $request)
    {
        session()->put('admin_login', '1');
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ],  [
            'email.required' => trans('messages.email_required'),
            'email.email' => trans('messages.valid_email'),
            'password.required' => trans('messages.password_required')
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if (Auth::attempt($request->only('email', 'password'))) {
                if (!Auth::user()) {
                    return Redirect::to('/auth')->with('error', Session::get('from_message'));
                }
                if (Auth::user()->type == 1) {
                    session()->forget('admin_login', '1');
                    return redirect()->route('dashboard');
                } else if (Auth::user()->type == 4) {
                    if (Auth::user()->is_available == 1) {
                        session()->forget('admin_login', '1');
                        return redirect()->route('dashboard');
                    } else {
                        Auth::logout();
                        return redirect()->back()->with('error', trans('messages.email_pass_invalid'));
                    }
                } else {
                    Auth::logout();
                    return redirect()->back()->with('error', trans('messages.email_pass_invalid'));
                }
            } else {
                return redirect()->back()->with('error', trans('messages.email_pass_invalid'));
            }
        }
    }
    public function send_pass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ],  [
            'email.required' => trans('messages.email_required'),
            'email.email' => trans('messages.valid_email'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $checkadmin = User::where('email', $request->email)->whereIn('type', [1, 4])->first();
            if (!empty($checkadmin)) {
                $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
                $pass = helper::send_pass($checkadmin->email, $checkadmin->name, $password);
                if ($pass == 1) {
                    $checkadmin->password = Hash::make($password);
                    $checkadmin->save();
                    return redirect('admin')->with('success', trans('messages.password_sent'));
                } else {
                    return redirect()->back()->with('error', trans('messages.email_error'));
                }
            } else {
                return redirect()->back()->with('error', trans('messages.invalid_email'));
            }
        }
    }
    public function changestatus(Request $request)
    {
        if(@helper::appdata()->timezone != ""){
            date_default_timezone_set(helper::appdata()->timezone);
        }
        $status = User::find(Auth::user()->id);
        $status->is_online = $status->is_online == 1 ? 2 : 1;
        $status->save();
        return redirect()->back()->with('success',trans('messages.success'));
    }

    public function editprofile(request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users,name,' . Auth::user()->id . ',id,is_deleted,2,type,1',
            'email' => 'required|unique:users,email,' . Auth::user()->id . ',id,is_deleted,2,type,1',
            'mobile' => 'required|unique:users,mobile,' . Auth::user()->id . ',id,is_deleted,2,type,1',
        ], [
            "name.required" => trans('messages.name_required'),
            "email.required" => trans('messages.email_required'),
            "email.unique" => trans('messages.email_exist'),
            "mobile.required" => trans('messages.mobile_required'),
            "mobile.unique" => trans('messages.mobile_exist'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if ($request->hasfile('profile')) {
                $this->assertValidImage($request, 'profile', true);
                if (Auth::user()->profile_image != "unknown.png" && file_exists(env('ASSETSPATHURL') . 'admin-assets/images/profile/' . Auth::user()->profile_image)) {
                    unlink(env('ASSETSPATHURL') . 'admin-assets/images/profile/' . Auth::user()->profile_image);
                }
                $profile = 'profile-' . uniqid() . '.' . $request->profile->getClientOriginalExtension();
                $request->profile->move(env('ASSETSPATHURL') . 'admin-assets/images/profile', $profile);
                $checkuser = User::find(Auth::user()->id);
                $checkuser->profile_image = $profile;
                $checkuser->save();
            }
            $checkuser = User::find(Auth::user()->id);
            $checkuser->name = $request->name;
            $checkuser->email = $request->email;
            $checkuser->mobile = $request->mobile;
            $checkuser->save();
            return redirect()->back()->with('success', trans('messages.success'));
        }
    }
    public function changepassword(request $request)
    {
        $validator = Validator::make($request->all(), [
            'newpassword' => 'required|min:6',
            'confirmpassword' => 'required|same:newpassword|min:6',
        ], [
            'newpassword.required' => trans('messages.new_password_required'),
            'confirmpassword.required_with' => trans('messages.confirm_password_required'),
            'confirmpassword.same' => trans('messages.confirm_password_same')
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if ($request->oldpassword == $request->newpassword) {
                return redirect()->back()->with('error', trans('messages.new_password_diffrent'));
            } else {
                if (Hash::check($request->oldpassword, Auth::user()->password)) {
                    $setting = User::where('id', Auth::user()->id)->update(['password' => Hash::make($request->newpassword)]);
                    return redirect()->back()->with('success', trans('messages.success'));
                } else {
                    return redirect()->back()->with('error', trans('messages.old_password_invalid'));
                }
            }
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return Redirect::to('admin/');
    }

    public function sessionsave(Request $request)
    {
        session()->put('demo', $request->demo_type);

        return response()->json(['status' => 1,'msg' => trans('messages.success')], 200);
    }
}
