<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintJob extends Model
{
    use HasFactory;

    protected $fillable = ['printer_id','mac_id','order_id','status'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
