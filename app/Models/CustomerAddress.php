<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'address_type',
        'address_id',
        'state_id',
        'city',
        'zip',
        'address',
        'branch_id',
        'date',
        'time',
    ];

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id','id');
    }
}
