<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesktopOrderState extends Model
{
    protected $fillable = ['branch_id', 'last_notified_order_id', 'last_printed_order_id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
