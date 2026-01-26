<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $table='order_details';
    protected $fillable = [
        'order_id',
        'user_id',

        'item_id',
        'deal_id',
        'custom_pizza_id',

        'item_name',
        'item_type',
        'item_image',

        'crust_id',
        'size_id',

        'qty',
        'item_price',
        'tax',

        'dipping_quantity',
        'dipping_name',
        'dipping_price',

        'addons_id',
        'addons_name',
        'addons_price',
        'addons_total_price',

        'extras_id',
        'extras_name',
        'extras_price',
        'extras_total_price',
    ];
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
