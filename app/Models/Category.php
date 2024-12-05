<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['category_name', 'image'];

    public function category_info()
    {
        return $this->hasOne('App\Models\Category', 'id')->select('id', 'category_name', 'slug');
    }

    public function item_info()
    {
        return $this->hasMany('App\Models\Item', 'cat_id', 'id');
    }
}
