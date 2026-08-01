<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\DesktopOrderState;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Services\OrderPrintEligibility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
     * Per-branch desktop companion status for the admin dashboard: whether a
     * branch currently has the companion open, its printer/buzzer status,
     * and whether it's reachable over the internet.
     *
     * A branch counts as "online" only if it heartbeated (via sync()) within
     * its own poll interval, times 3 (missing a couple of cycles tolerates a
     * blip without flapping the badge), floored at 30s. Internet status is
     * derived the same way rather than self-reported, since a companion that
     * can't reach the internet can't reach this endpoint to say so.
     */
    public function status()
    {
        $branches = Branch::orderBy('name')->get(['id', 'name']);
        $states = DesktopOrderState::whereIn('branch_id', $branches->pluck('id'))
            ->get()
            ->keyBy('branch_id');

        $now = now();

        $data = $branches->map(function (Branch $branch) use ($states, $now) {
            $state = $states->get($branch->id);
            $lastSeenAt = $state?->updated_at;
            $thresholdSeconds = max((int) ($state->poll_interval_seconds ?? 5) * 3, 30);
            $isOnline = $lastSeenAt && $lastSeenAt->gt($now->copy()->subSeconds($thresholdSeconds));

            return [
                'branch_id' => $branch->id,
                'branch_name' => $branch->name,
                'branch_status' => $isOnline ? 'online' : 'offline',
                'printer_status' => $isOnline ? ($state->printer_status ?? 'not-configured') : 'offline',
                'printer_name' => $isOnline ? ($state->printer_name ?? null) : null,
                'buzzer_status' => $isOnline ? ($state->buzzer_status ?? 'stopped') : 'stopped',
                'internet_status' => $isOnline ? 'connected' : 'offline',
                'last_seen_at' => $lastSeenAt?->toIso8601String(),
            ];
        })->values();

        return response()->json(['branches' => $data]);
    }

    /**
     * Return any orders that are new since this branch's desktop companion
     * last checked in, and advance its notification/print cursors.
     */
    public function sync(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'required|integer|exists:branches,id',
            'printer_status' => 'nullable|string|in:not-configured,ready,not-found,error,checking',
            'printer_name' => 'nullable|string|max:255',
            'service_running' => 'nullable|boolean',
            'poll_interval_seconds' => 'nullable|integer|min:1|max:3600',
        ]);
        $branchId = (int) $validated['branch_id'];

        $state = DesktopOrderState::firstOrCreate(['branch_id' => $branchId]);

        // Heartbeat: the desktop companion polls this endpoint on a timer, so
        // every request also reports its current local status. `updated_at`
        // (bumped by the unconditional save() below) doubles as "last seen",
        // used by DesktopSyncController::status() to derive branch/internet
        // online-ness for the admin dashboard.
        if (array_key_exists('printer_status', $validated)) {
            // Log::info('Printer status updated.', [
            //     'printer_status' => $validated['printer_status'],
            // ]);

            $state->printer_status = $validated['printer_status'];
            $state->updated_at = now();
        }
        if (array_key_exists('printer_name', $validated)) {
            // Log::info('Printer name updated.', [
            //     'printer_name' => $validated['printer_name'],
            // ]);
            $state->printer_name = $validated['printer_name'];
            $state->updated_at = now();
        }
        if (array_key_exists('service_running', $validated)) {
            // Log::info('Service status updated.', [
            //     'service_running' => $validated['service_running'],
            // ]);
            $state->buzzer_status = $validated['service_running'] ? 'running' : 'stopped';
            $state->updated_at = now();
        }
        if (array_key_exists('poll_interval_seconds', $validated)) {
            // Log::info('Poll interval updated.', [
            //     'poll_interval_seconds' => $validated['poll_interval_seconds'],
            // ]);
            $state->poll_interval_seconds = $validated['poll_interval_seconds'];
            $state->updated_at = now();
        }

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
            ->with('size', 'crust','items')
            ->get()
            ->map(fn (OrderDetails $line) => [
                'name' => $line->item_name,
                'size' => $line->size->name ?? null,
                'crust' => $line->crust->name ?? null,
                'qty' => (int) $line->qty,
                'price' => (float) $line->item_price,
                'category' => $line->items->category_info->category_name ?? null,
                'sub_category' => $line->items->subcategory_info->name ?? null,
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
        $taxArray = [];

        if ($order->tax_amount && $order->tax_name) {
            $tax = explode('|', $order->tax_amount);
            $tax_name = explode('|', $order->tax_name);

            foreach ($tax as $key => $tax_value) {
                $taxArray[] = [
                    'name' => $tax_name[$key] ?? '',
                    'amount' => (float) $tax_value,
                ];
            }
        }

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
            'order_notes' => $order->order_notes,
            'payment_method' => "Card(stripe)",
            'totals' =>  [
                'discount_amount' => (float) $order->discount_amount,
                'offer_code' => $order->offer_code,
                'delivery_charge' => (float) $order->delivery_charge,
                'tax_amount' => (float) $order->tax_amount,
                'tax_name' => $order->tax_name,
                'tip' => (float) $order->tip,
                'grand_total' => (float) $order->grand_total,
                'taxes' => $taxArray,
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
