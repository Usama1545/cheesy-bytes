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
        $item = Item::find($event->deal->product_id);

        if (!$item || empty($item->branch_ids)) {
            return;
        }

        $branchIds = collect(explode(',', $item->branch_ids))
            ->map(fn ($id) => trim($id))
            ->filter();

        $userIds = User::whereIn('branch_id', $branchIds)
            ->pluck('id');

        $tokens = UserDeviceToken::whereIn('user_id', $userIds)
            ->pluck('fcm_token')
            ->filter()
            ->values()
            ->toArray();

        if (empty($tokens)) {
            return;
        }

        $messaging = app('firebase.messaging');

        $message = CloudMessage::new()
            ->withNotification(Notification::create(
                'New Deal Landed',
                'A new deal has landed for you. Check it out!'
            ))
            ->withData([
                'type' => 'new_offer',
            ]);

        $response = $messaging->sendMulticast($message, $tokens);

        Log::info('FCM response', [
            'success' => $response->successes()->count(),
            'failure' => $response->failures()->count(),
        ]);
    }


}
