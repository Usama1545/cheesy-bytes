<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shippingarea extends Model
{
    use HasFactory;
    protected $table = 'shipping_area';

    protected $fillable = ['name','state_id','branch_id','city','delivery_charge'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
