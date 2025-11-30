<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\itemPrice;


class Item extends Model
{
    protected $table = 'item';
    protected $fillable = ['cat_id', 'subcat_id', 'item_name', 'branch_ids','slug', 'image', 'item_type', 'has_variation', 'attribute', 'price', 'original_price', 'addons_id', 'item_description', 'preparation_time', 'tax', 'avg_ratting', 'discount_percentage', 'item_status', 'is_featured', 'is_deleted', 'delivery_time'];

    public function subcategory_info()
    {
        return $this->hasOne('App\Models\Subcategory', 'id', 'subcat_id')->select('subcategories.id', 'subcategories.subcategory_name', 'subcategories.slug', 'subcategories.reorder_id');
    }
    public function category_info()
    {
        return $this->hasOne('App\Models\Category', 'id', 'cat_id')->select('categories.id', 'categories.category_name', 'categories.slug', 'categories.reorder_id', DB::raw("CONCAT('" . url(env('ASSETSPATHURL') . 'admin-assets/images/category/') . "/', image) AS image_url"));
    }
    public function item_image()
    {
        return $this->hasOne('App\Models\ItemImages', 'item_id', 'id')->select('item_images.id', 'item_images.image as image_name', 'item_images.item_id', DB::raw("CONCAT('" . url(env('ASSETSPATHURL') . 'admin-assets/images/item/') . "/', item_images.image) AS image_url"));
    }
    public function item_images()
    {
        return $this->hasMany('App\Models\ItemImages', 'item_id', 'id')->select('item_images.id', 'item_images.image as image_name', 'item_images.item_id', DB::raw("CONCAT('" . url(env('ASSETSPATHURL') . 'admin-assets/images/item/') . "/', item_images.image) AS image_url"));
    }
    public function extras()
    {
        return $this->hasMany('App\Models\Extra', 'item_id', 'id')->select('id', 'name', 'price', 'item_id','branch_id','is_default');
    }

    public function prices()
    {
        return $this->hasMany('App\Models\itemPrice','item_id','id');
    }

    public function pricing()
    {
        return $this->hasMany(ProductSizeCrust::class);
    }

    public function pizzaPrices()
    {
        return $this->hasMany(PizzaPrice::class);
    }
    
    public function itemPrices()
    {
        return $this->hasMany(ItemPrice::class);
    }
    
    
    public function branches()
    {
        return $this->hasMany(Branch::class, 'id', 'branch_ids');
    }

}
