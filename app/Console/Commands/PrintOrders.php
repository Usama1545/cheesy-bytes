<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PrintOrders extends Command
{
    protected $signature = 'app:print-orders';
    protected $description = 'Print orders at branches';

    public function handle()
    {
        // $this->info('Printing orders...');
        
   
        app(\App\Http\Controllers\admin\AdminController::class)->printOrders();
        
        // Option 2: Or call the same URL internally (more secure than wget)
        // Http::get('https://thecheesybite.com/api/print-orders');
        
        return Command::SUCCESS;
    }
}