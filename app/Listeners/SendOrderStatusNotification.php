<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use App\Events\OrderStatusChanged;
use App\Models\UserDeviceToken;

class SendOrderStatusNotification implements ShouldQueue
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
    public function handle(OrderStatusChanged $event)
    {
        $tokens = UserDeviceToken::where('user_id', $event->order->user_id)
            ->pluck('fcm_token')
            ->toArray();

        if (empty($tokens)) return;

        $messaging = app('firebase.messaging');

        $message = CloudMessage::new()
            ->withNotification(Notification::create(
                'Order Update',
                "Your order has just been {$event->newStatus}. We're on it!"
            ))
            ->withData([
                'order_id' => (string) $event->order->id,
                'status' => $event->newStatus,
            ]);

        $messaging->sendMulticast($message, $tokens);
    }

}
