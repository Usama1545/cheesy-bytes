<?php

namespace App\Listeners;

use App\Events\DealCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use App\Models\Item;
use App\Models\User;
use App\Models\UserDeviceToken;
use Illuminate\Support\Facades\Log;

class SendDealCreatedNotification implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(DealCreated $event)
    {
        $tokens = UserDeviceToken::whereNotNull('fcm_token')
            ->pluck('fcm_token')
            ->filter()
            ->unique()
            ->values();

        if ($tokens->isEmpty()) {
            return;
        }

        $messaging = app('firebase.messaging');

        $message = CloudMessage::new()
            ->withNotification(Notification::create(
                'New Deal Landed',
                'A new deal has landed for you. Check it out!'
            ))
            ->withData([
                'type'      => 'new_offer',
                'deal_id'   => (string) $event->deal->id,
                'title'     => $event->deal->title ?? '',
                'source'    => 'deal_created',
            ]);

        $tokens->chunk(500)->each(function ($chunk) use ($messaging, $message, $event) {
            $response = $messaging->sendMulticast($message, $chunk->toArray());

            Log::info('FCM deal notification chunk sent', [
                'deal_id' => $event->deal->id,
                'sent'    => $chunk->count(),
                'success' => $response->successes()->count(),
                'failure' => $response->failures()->count(),
            ]);
        });
    }
}
