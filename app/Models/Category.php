<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Session;
class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['category_name', 'image','branch_ids'];
    protected $appends = ['image_url'];

    public function category_info()
    {
        return $this->hasOne('App\Models\Category', 'id')->select('id', 'category_name', 'slug');
    }

    public function item_info()
    {
        return $this->hasMany('App\Models\Item', 'cat_id', 'id')->where(function($query) {
            $branchId = Session::get('branch_id');
            $query->where('item.branch_ids', 'like', "%,$branchId,%") // Match middle
            ->orWhere('item.branch_ids', 'like', "$branchId,%") // Match start
            ->orWhere('item.branch_ids', 'like', "%,$branchId") // Match end
            ->orWhere('item.branch_ids', '=', $branchId);
        });
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        return url(env('ASSETSPATHURL') . 'admin-assets/images/category/'.$this->image);
    }

}
