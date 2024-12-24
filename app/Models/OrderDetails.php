<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $table='order_details';
    protected $fillable=['user_id','order_id','item_id','price','qty','custom_pizza_id','dipping_price','dipping_name','dipping_quantity','size_id','crust_id'];
    public function items(){
        return $this->hasOne('App\Models\Item','id','item_id');
    }

    public function custom_pizza()
    {
        return $this->belongsTo(CustomPizza::class, 'custom_pizza_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function crust()
    {
        return $this->belongsTo(Crust::class, 'crust_id');
    }
}
