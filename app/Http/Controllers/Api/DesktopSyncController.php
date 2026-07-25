<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\DesktopOrderState;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Services\OrderPrintEligibility;
use Illuminate\Http\Request;

class DesktopSyncController extends Controller
{
    /**
     * All branches, for the desktop companion's setup wizard.
     *
     * Unlike SiteController::branches() (storefront-only: is_mobile branches
     * with a schedule entry for today), this is unfiltered — any branch can
     * run the desktop companion regardless of storefront/mobile visibility.
     */
    public function branches()
    {
        return response()->json(
            Branch::orderBy('name')->get(['id', 'name'])
        );
    }

    /**
     * Return any orders that are new since this branch's desktop companion
     * last checked in, and advance its notification/print cursors.
     */
    public function sync(Request $request)
    {
        $branchId = (int) $request->validate([
            'branch_id' => 'required|integer|exists:branches,id',
        ])['branch_id'];

        $state = DesktopOrderState::firstOrCreate(['branch_id' => $branchId]);

        $notifyOrders = OrderPrintEligibility::apply(
            Order::where('branch_id', $branchId)
                ->where('id', '>', $state->last_notified_order_id ?? 0)
        )->orderBy('id')->get();

        $printOrders = OrderPrintEligibility::apply(
            Order::where('branch_id', $branchId)
                ->where('id', '>', $state->last_printed_order_id ?? 0)
        )->with('branch')->orderBy('id')->get();

        $notifications = $notifyOrders->map(fn (Order $order) => [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'order_type' => $order->order_type,
            'grand_total' => (float) $order->grand_total,
            'created_at' => $order->created_at,
        ])->values();

        $printJobs = $printOrders->map(fn (Order $order) => $this->buildPrintJob($order))->values();

        if ($notifyOrders->isNotEmpty()) {
            $state->last_notified_order_id = $notifyOrders->max('id');
        }

        if ($printOrders->isNotEmpty()) {
            $state->last_printed_order_id = $printOrders->max('id');
        }

        $state->save();

        return response()->json([
            'server_time' => now()->toIso8601String(),
            'notifications' => $notifications,
            'print_jobs' => $printJobs,
        ]);
    }

    protected function buildPrintJob(Order $order): array
    {
        $items = OrderDetails::where('order_id', $order->id)
            ->whereNull('custom_pizza_id')
            ->with('size', 'crust')
            ->get()
            ->map(fn (OrderDetails $line) => [
                'name' => $line->item_name,
                'size' => $line->size->name ?? null,
                'crust' => $line->crust->name ?? null,
                'qty' => (int) $line->qty,
                'price' => (float) $line->item_price,
                'addons' => $this->splitPipeList($line->addons_name, $line->addons_price),
                'extras' => $this->splitPipeList($line->extras_name, $line->extras_price),
                'line_total' => (float) (($line->item_price + $line->addons_total_price + $line->extras_total_price) * $line->qty),
            ]);

        $customItems = OrderDetails::where('order_id', $order->id)
            ->whereNotNull('custom_pizza_id')
            ->with('custom_pizza.toppings', 'custom_pizza.size', 'custom_pizza.crust', 'custom_pizza.sauce')
            ->get()
            ->map(fn (OrderDetails $line) => [
                'name' => $line->item_name,
                'size' => $line->custom_pizza->size->name ?? null,
                'crust' => $line->custom_pizza->crust->name ?? null,
                'sauce' => $line->custom_pizza->sauce->name ?? null,
                'toppings' => optional($line->custom_pizza)->toppings?->pluck('name')->values() ?? [],
                'qty' => (int) $line->qty,
                'price' => (float) $line->item_price,
                'addons' => [],
                'extras' => [],
                'line_total' => (float) (($line->item_price + $line->addons_total_price + $line->extras_total_price) * $line->qty),
            ]);

        return [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'order_type' => $order->order_type,
            'created_at' => $order->created_at,
            'branch' => [
                'id' => $order->branch->id ?? $order->branch_id,
                'name' => $order->branch->name ?? null,
            ],
            'customer' => [
                'name' => $order->name,
                'email' => $order->email,
                'mobile' => $order->mobile,
            ],
            'delivery_date' => $order->delivery_date,
            'delivery_time' => $order->delivery_time,
            'address' => $order->address,
            'items' => $items->concat($customItems)->values(),
            'totals' => [
                'discount_amount' => (float) $order->discount_amount,
                'offer_code' => $order->offer_code,
                'delivery_charge' => (float) $order->delivery_charge,
                'tax_amount' => (float) $order->tax_amount,
                'tax_name' => $order->tax_name,
                'tip' => (float) $order->tip,
                'grand_total' => (float) $order->grand_total,
            ],
        ];
    }

    /**
     * order_details stores addon/extra name+price as pipe-delimited strings
     * (see AdminController::formatContent) rather than a normalized table.
     * The separator isn't consistently "| " across write paths (some rows
     * have no space after the pipe), so split on optional trailing whitespace.
     */
    protected function splitPipeList(?string $names, ?string $prices): array
    {
        if (empty($names)) {
            return [];
        }

        $namesArr = preg_split('/\|\s*/', $names);
        $pricesArr = preg_split('/\|\s*/', (string) $prices);

        $result = [];
        foreach ($namesArr as $index => $name) {
            $name = trim($name);
            if ($name === '') {
                continue;
            }

            $result[] = [
                'name' => $name,
                'price' => (float) ($pricesArr[$index] ?? 0),
            ];
        }

        return $result;
    }
}
