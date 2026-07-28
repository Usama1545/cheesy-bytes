<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesktopOrderState extends Model
{
    protected $fillable = [
        'branch_id',
        'last_notified_order_id',
        'last_printed_order_id',
        'printer_status',
        'printer_name',
        'buzzer_status',
        'poll_interval_seconds',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
