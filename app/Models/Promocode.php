<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    protected $table = 'promocode';
    protected $fillable = ['offer_name', 'offer_code', 'offer_amount', 'description'];
}
