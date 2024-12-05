<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPizza extends Model
{
    use HasFactory;

    protected $fillable = ['sauce_ids','size_id','crust_id','base_price'];

    public function toppings()
    {
        return $this->belongsToMany(PizzaTopping::class, 'custom_pizza_topping')
            ->withPivot('position', 'price');
    }

    public function size()
    {
        return $this->belongsTo(CustomPizzaSize::class, 'size_id');
    }

    public function crust()
    {
        return $this->belongsTo(CustomPizzaCrust::class, 'crust_id');
    }

}
