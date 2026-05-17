<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $fillable = ['user_id', 'item_id', 'addons_id', 'qty', 'price','custom_pizza_id','crust_id','size_id','dipping_quantity',
    'dipping_name','dipping_price','deal_id','deal_category_id'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function addons()
    {
        return $this->belongsTo(Addons::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customPizza()
    {
        return $this->belongsTo(CustomPizza::class);
    }

    public function crust()
    {
        return $this->belongsTo(Crust::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function dealCategory()
    {
        return $this->belongsTo(DealCategory::class);
    }

    public function dealItem()
    {
        return $this->belongsTo(DealItem::class);
    }

    public function taxes()
    {
        return $this->belongsTo(Tax::class, 'tax', 'id');
    }
}
