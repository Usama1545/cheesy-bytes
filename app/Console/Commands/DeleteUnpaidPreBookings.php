<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteUnpaidPreBookings extends Command
{
    protected $signature = 'app:delete-unpaid-pre-bookings';
    protected $description = 'Delete unpaid pre-bookings daily';

    public function handle()
    {
        $this->info('Deleting unpaid pre-bookings...');
        
        // Move your deletion logic here or call the controller
        app(\App\Http\Controllers\admin\OrderController::class)->deleteUnpaidPreBookings();
        
        return Command::SUCCESS;
    }
}