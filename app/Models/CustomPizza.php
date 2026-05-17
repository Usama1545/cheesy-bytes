<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPizza extends Model
{
    use HasFactory;

    protected $fillable = ['sauce_id','size_id','crust_id','base_price','bake','cut','seasoning'];

    public function toppings()
    {
        return $this->belongsToMany(CustomPizzaTopping::class, 'custom_pizza_selected_toppings', 'pizza_id', 'topping_id')
            ->withPivot('side', 'quantity');
    }
    public function dipping()
    {
        return $this->belongsToMany(Sides::class, 'custom_pizza_selected_dippings', 'pizza_id', 'dipping_id')
            ->withPivot( 'quantity');
    }

    public function size()
    {
        return $this->belongsTo(CustomPizzaSize::class, 'size_id');
    }

    public function crust()
    {
        return $this->belongsTo(CustomPizzaCrust::class, 'crust_id');
    }
    public function sauce()
    {
        return $this->belongsTo(CustomPizzaSauce::class, 'sauce_id');
    }

    public function sauces()
    {
        return $this->belongsToMany(CustomPizzaSauce::class, 'custom_pizza_selected_sauces', 'pizza_id', 'sauce_id')
            ->withPivot('side', 'quantity');
    }


}
