<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'deal_id',
        'date',
        'time',
        'repeat_type',
        'days',
        'is_active',
        'last_sent_at',
        'message',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i:s',
        'days' => 'array',
        'is_active' => 'boolean',
        'last_sent_at' => 'datetime',
    ];

    public function deal()
    {
        return $this->belongsTo(TopDeals::class);
    }
}
