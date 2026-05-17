<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DealNotification;
use App\Models\UserDeviceToken;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendDealNotifications extends Command
{
    protected $signature = 'deals:send-notifications';
    protected $description = 'Send scheduled deal notifications';

    public function handle()
    {
        $tz = 'America/Chicago';

        $now = Carbon::now($tz);

        $notifications = DealNotification::with('deal.product')
            ->where('is_active', true)
            ->get();

        foreach ($notifications as $notification) {

            if (!$notification->deal || !$notification->deal->product) {
                continue;
            }

            $today = strtolower($now->format('D')); // mon, tue...

            $notificationTime = Carbon::parse($notification->time, $tz);

            if ($now->format('H:i') !== $notificationTime->format('H:i')) {
                continue;
            }

            if ($notification->repeat_type === 'weekly') {

                if (!$notification->days || !in_array($today, $notification->days)) {
                    continue;
                }

                if ($notification->last_sent_at &&
                    $notification->last_sent_at->timezone($tz)->format('Y-m-d H:i') === $now->format('Y-m-d H:i')) {
                    continue;
                }

            } else {
                // one-time
                if (!$notification->date || !$notification->date->timezone($tz)->isSameDay($now)) {
                    continue;
                }

                if ($notification->last_sent_at) {
                    continue;
                }
            }

            $this->sendNotification($notification);

            $notification->update([
                'last_sent_at' => Carbon::now() // store in server/default TZ (recommended)
            ]);
        }
    }

    protected function sendNotification($notification)
    {
        $product = $notification->deal->product;

        // No product or no branches → skip
        if (!$product || !$product->branch_ids) {
            Log::info('Skipped notification: no branch_ids', [
                'deal_id' => $notification->deal->id
            ]);
            return;
        }

        // Convert "3,2" → [3,2]
        $branchIds = collect(explode(',', $product->branch_ids))
            ->map(fn($id) => (int) trim($id))
            ->filter();

        // Get tokens only for users in those branches
        $tokens = UserDeviceToken::whereNotNull('fcm_token')
            ->whereHas('user', function ($q) use ($branchIds) {
                $q->whereIn('branch_id', $branchIds);
            })
            ->pluck('fcm_token')
            ->filter()
            ->unique()
            ->values();

        if ($tokens->isEmpty()) {
            Log::info('No tokens found for branches', [
                'branches' => $branchIds
            ]);
            return;
        }

        $messaging = app('firebase.messaging');

        $deal = $notification->deal;

        $message = CloudMessage::new()
            ->withNotification(Notification::create(
                'Deal Reminder',
                $notification?->message ?? 'A deal you might like is waiting for you!'
            ))
            ->withData([
                'type'    => 'scheduled_offer',
                'deal_id' => (string) $deal?->id,
                'title'   => $deal?->title ?? 'A deal you might like!',
                'source'  => 'scheduled_notification',
            ]);

        $tokens->chunk(500)->each(function ($chunk) use ($messaging, $message, $notification, $branchIds) {

            try {
                $response = $messaging->sendMulticast($message, $chunk->toArray());

                Log::info('Scheduled deal notification sent', [
                    'deal_id' => $notification->deal->id,
                    'branches'=> $branchIds,
                    'sent'    => $chunk->count(),
                    'success' => $response->successes()->count(),
                    'failure' => $response->failures()->count(),
                ]);

            } catch (\Exception $e) {
                Log::error('FCM send error', [
                    'deal_id' => $notification->deal->id,
                    'error'   => $e->getMessage()
                ]);
            }
        });
    }
}