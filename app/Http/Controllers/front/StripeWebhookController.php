<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe;

class StripeWebhookController extends Controller
{
    // All branches share this one endpoint, so we identify which branch a
    // request belongs to by trying each branch's webhook secret in turn.
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        $event = null;

        foreach (Branch::whereNotNull('webhook_secret')->where('webhook_secret', '!=', '')->get() as $branch) {
            try {
                $event = Stripe\Webhook::constructEvent($payload, $sigHeader, $branch->webhook_secret);
                break;
            } catch (\UnexpectedValueException $e) {
                return response('Invalid payload', 400);
            } catch (Stripe\Exception\SignatureVerificationException $e) {
                continue;
            }
        }

        if (!$event) {
            Log::warning('Stripe webhook: signature did not match any branch webhook secret');
            return response('Signature verification failed', 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
            case 'checkout.session.async_payment_succeeded':
                $this->markOrderPaid($event->data->object);
                break;
        }

        return response()->json(['status' => 'ok']);
    }

    private function markOrderPaid($session)
    {
        if ($session->payment_status !== 'paid') {
            return;
        }

        $orderNumber = $session->metadata->order_number ?? null;
        if (!$orderNumber) {
            Log::warning('Stripe webhook: checkout session had no order_number metadata', ['session_id' => $session->id]);
            return;
        }

        Order::where('order_number', $orderNumber)
            ->where('payment_status', '!=', 2)
            ->update([
                'payment_status' => 2,
                'transaction_id' => $session->payment_intent ?? $session->id,
            ]);
    }
}
