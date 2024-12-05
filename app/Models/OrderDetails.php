<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $table='order_details';
    protected $fillable=['user_id','order_id','item_id','price','qty'];
    public function items(){
        return $this->hasOne('App\Models\Item','id','item_id');
    }
}
