<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $table='order_details';
    protected $fillable=['user_id','order_id','item_id','price','qty','custom_pizza_id'];
    public function items(){
        return $this->hasOne('App\Models\Item','id','item_id');
    }

    public function custom_pizza(){
        return $this->hasOne(CustomPizza::class,'id','custom_pizza_id');
    }
}
