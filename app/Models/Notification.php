<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table='notification';
    protected $fillable=['title','message'];

    public function category_info(){
        return $this->hasOne('App\Models\Category','id','cat_id')->select('id','category_name',\DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/category/')."/', image) AS image_url"));
    }
    public function item_info(){
        return $this->hasOne('App\Models\Item','id','item_id')->select('id','item_name',\DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/item/')."/', image) AS image_url"));
    }
}
