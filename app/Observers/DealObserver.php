<?php

namespace App\Observers;

use App\Events\DealCreated;
use App\Models\TopDeals;

class DealObserver
{
    /**
     * Handle the TopDeals "created" event.
     */
    public function created(TopDeals $deal): void
    {
        event(new DealCreated($deal));
    }

    /**
     * Handle the TopDeals "updated" event.
     */
    public function updated(TopDeals $deal): void
    {
        //
    }

    /**
     * Handle the TopDeals "deleted" event.
     */
    public function deleted(TopDeals $deal): void
    {
        //
    }

    /**
     * Handle the TopDeals "restored" event.
     */
    public function restored(TopDeals $deal): void
    {
        //
    }

    /**
     * Handle the TopDeals "force deleted" event.
     */
    public function forceDeleted(TopDeals $deal): void
    {
        //
    }
}
