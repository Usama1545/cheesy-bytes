<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPizzaSelectedTopping extends Model
{
    use HasFactory;

    protected $fillable = ['topping_id','pizza_id','side','quantity'];

}
