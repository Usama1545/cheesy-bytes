<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $table = 'order';
    protected $fillable = ['user_id', 'order_total', 'transaction_id', 'transaction_type', 'address', 'promocode', 'delivery_date', 'delivery_time'];
    public function user_info()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id')->select('id', 'name', 'email', 'mobile', 'token', DB::raw("CONCAT('" . url(env('ASSETSPATHURL') . 'admin-assets/images/profile/') . "/', profile_image) AS profile_image"));
    }
    public function driver_info()
    {
        return $this->hasOne('App\Models\User', 'id', 'driver_id')->select('id', 'name', 'email', 'mobile', 'token', DB::raw("CONCAT('" . url(env('ASSETSPATHURL') . 'admin-assets/images/profile/') . "/', profile_image) AS profile_image"));
    }
}
