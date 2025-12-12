<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $table = 'order';
    protected $fillable = ['user_id', 'order_total', 'transaction_id', 'transaction_type', 'address', 'promocode', 'delivery_date', 'delivery_time','delivery_area','branch_id','tip'];
    public function user_info()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id')->select('id', 'name', 'email', 'mobile', 'token', DB::raw("CONCAT('" . url(env('ASSETSPATHURL') . 'admin-assets/images/profile/') . "/', profile_image) AS profile_image"));
    }
    public function driver_info()
    {
        return $this->hasOne('App\Models\User', 'id', 'driver_id')->select('id', 'name', 'email', 'mobile', 'token', DB::raw("CONCAT('" . url(env('ASSETSPATHURL') . 'admin-assets/images/profile/') . "/', profile_image) AS profile_image"));
    }

    public function branch()
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }
    public function shipping()
    {
        return $this->hasOne(Shippingarea::class, 'id', 'delivery_area');
    }

    public function items()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }

}
