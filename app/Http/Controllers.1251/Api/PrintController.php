<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\PrintJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class PrintController extends Controller
{
    /**
     * Fetch a print job for the printer.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchPrintJob(Request $request)
    {

        $printerId = $request->header('X-Printer-ID');
        $macId = $request->header('X-Mac');

        Log::channel('print_service')->info("Fetcher print job request received", ['printer_id' => $printerId, 'mac_id' => $macId]);

        // Get the pending print job
        // $printJob = $this->getPendingPrintJob($printerId, $macId);

        // if (!$printJob) {
        //     Log::info("No pending print jobs for printer ID: $printerId or MAC: $macId");
        //     return response('No Content', 204); // No pending job
        // }

        // $order = Order::with(['user_info', 'driver_info'])
        //     ->where('id', $printJob->order_id)
        //     ->first();

        // if (!$order) {
        //     Log::error("Order not found for order_id: {$printJob->order_id}");
        //     return response()->json(['error' => 'Order not found'], 404);
        // }

        // $orderDetails = OrderDetails::where('order_id', $printJob->order_id)->get();

        try {
            // Render HTML for the print job
            // $jobData = View::make('admin.orders.invoicepdf', [
            //     'getorderdata' => $order,
            //     'ordersdetails' => $orderDetails
            // ])->render();

            // Prepare JSON for Star CloudPRNT
            $cloudPrntJob = [
                "action" => "print",
                "printjobid" => 1,
                "jobname" => "Order Invoice # 1",
                "jobdata" => "i am data",
                "response" => "ack",
                "deletejob" => true
            ];

            Log::channel('print_service')->info("Printer job 1 prepared for printer ID: $printerId");

            return response()->json($cloudPrntJob, 200);

        } catch (\Exception $e) {
            Log::error("Error rendering invoice for printer job: {$e->getMessage()}");
            return response()->json(['error' => 'Error generating printer content'], 500);
        }
    }


    public function fetchConPrintJob(Request $request)
    {

        $printerId = $request->header('X-Printer-ID');
        $macId = $request->header('X-Mac');

        Log::channel('print_service')->info("Fetch print job request received", ['printer_id' => $printerId, 'mac_id' => $macId]);

        // Get the pending print job
        // $printJob = $this->getPendingPrintJob($printerId, $macId);

        // if (!$printJob) {
        //     Log::info("No pending print jobs for printer ID: $printerId or MAC: $macId");
        //     return response('No Content', 204); // No pending job
        // }

        // $order = Order::with(['user_info', 'driver_info'])
        //     ->where('id', $printJob->order_id)
        //     ->first();

        // if (!$order) {
        //     Log::error("Order not found for order_id: {$printJob->order_id}");
        //     return response()->json(['error' => 'Order not found'], 404);
        // }

        // $orderDetails = OrderDetails::where('order_id', $printJob->order_id)->get();

        try {
            // Render HTML for the print job
            // $jobData = View::make('admin.orders.invoicepdf', [
            //     'getorderdata' => $order,
            //     'ordersdetails' => $orderDetails
            // ])->render();

            // Prepare JSON for Star CloudPRNT
            $cloudPrntJob = [
                "command" => "print",
                "printjobid" => 1,
                "jobname" => "Order Invoice # 1",
                "data" => [
                    "text" => "Printing",
                    "format" => "text"
                ],
                "response" => "ack",
                "deletejob" => true
            ];

            Log::channel('print_service')->info("Print job 1 prepared for printer ID: $printerId");

            return response()->json($cloudPrntJob, 200);

        } catch (\Exception $e) {
            Log::error("Error rendering invoice for print job: {$e->getMessage()}");
            return response()->json(['error' => 'Error generating print content'], 500);
        }
    }

    /**
     * Acknowledge a print job as processed.
     *
     * @param Request $request
     * @param int $jobId
     * @return \Illuminate\Http\Response
     */
    public function acknowledgePrintJob(Request $request, $jobId)
    {
        $printJob = PrintJob::find($jobId);

        if (!$printJob) {
            Log::error("Print job not found: $jobId");
            return response()->json(['error' => 'Print job not found'], 404);
        }

        // Update the status to processed
        $printJob->update(['status' => 'processed']);

        Log::info("Print job $jobId acknowledged and marked as processed");

        return response('Acknowledged', 200);
    }

    /**
     * Get the pending print job for the printer.
     *
     * @param string|null $printerId
     * @param string|null $macId
     * @return PrintJob|null
     */
    protected function getPendingPrintJob($printerId, $macId)
    {
        // Fetch the oldest pending print job for the given printer or MAC address
        return PrintJob::where(function ($query) use ($printerId, $macId) {
            $query->where('printer_id', $printerId)
                ->orWhere('mac_id', $macId);
        })
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->first();
    }
}
