<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryZone extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'city',
        'state',
        'zip',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
