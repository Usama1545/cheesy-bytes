<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cart; // Assuming your model is Cart
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use App\Models\UserDeviceToken;
use Illuminate\Support\Facades\Log;

class CheckCartAge extends Command
{
    protected $signature = 'cart:check-age';
    protected $description = 'Send notifications based on how long carts have been inactive';

    public function handle()
    {
        $cartsByUser = Cart::all()->groupBy('user_id');
    
        Log::info('Cart age job started', [
            'users_with_carts' => $cartsByUser->count(),
        ]);
    
        foreach ($cartsByUser as $userId => $userCarts) {
    
            // Collect all matching day thresholds for this user
            $matchedDays = [];
    
            foreach ($userCarts as $cart) {
                $daysOld = now()->diffInDays($cart->created_at);
    
                if (in_array($daysOld, [2, 4, 5, 8, 10, 15, 20, 30])) {
                    $matchedDays[] = $daysOld;
                }
            }
    
            // No cart qualifies → skip user
            if (empty($matchedDays)) {
                continue;
            }
    
            // Pick the highest priority day (e.g. 30 over 10)
            $daysToNotify = max($matchedDays);
    
            Log::info('Cart reminder triggered', [
                'user_id' => $userId,
                'days' => $daysToNotify,
            ]);
    
            $tokens = UserDeviceToken::where('user_id', $userId)
                ->pluck('fcm_token')
                ->filter()
                ->toArray();
    
            if (empty($tokens)) {
                continue;
            }
    
            $this->sendFirebaseNotification($tokens, $daysToNotify);
        }
    
        $this->info('Cart age notifications completed.');
    }

    
    protected function sendFirebaseNotification($tokens, $daysOld)
    {
        if (empty($tokens)) {
            return;
        }

        $messaging = app('firebase.messaging');

        $message = CloudMessage::new()
            ->withNotification(Notification::create(
                'Cart Reminder',
                "Your cart has been sitting for $daysOld days! Don't forget to check out."
            ))
            ->withData([
                'type' => 'cart_reminder',
                'days_old' => (string) $daysOld,
        ]);

        $response = $messaging->sendMulticast($message, $tokens);

        Log::info('FCM response', [
            'success' => $response->successes()->count(),
            'failure' => $response->failures()->count(),
        ]);
    }

}
