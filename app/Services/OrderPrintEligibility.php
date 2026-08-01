<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;

/**
 * Shared "ready to print" rule used by both the PrintNode cron
 * (AdminController::printOrders) and the desktop companion sync endpoint:
 * online orders (transaction_type 15) must be paid (payment_status 2);
 * all other order types are eligible regardless of payment_status.
 */
class OrderPrintEligibility
{
    public static function apply(Builder $query): Builder
    {
        return $query->where(function (Builder $query) {
            $query->where(function (Builder $query) { 
                $query->where('transaction_type', 15)
                    ->where('payment_status', 2);
            });
        });
    }
}
