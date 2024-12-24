<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $fillable = ['user_id', 'item_id', 'addons_id', 'qty', 'price','custom_pizza_id','crust_id','size_id','dipping_quantity',
    'dipping_name','dipping_price'];
}
