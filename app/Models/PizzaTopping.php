<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PizzaTopping extends Model
{
    use HasFactory;
    protected $table = 'custom_pizza_selected_toppings';

    protected $fillable = ['pizza_id','topping_id','side','quantity'];
    public function customPizzas()
    {
        return $this->belongsToMany(CustomPizza::class, 'custom_pizza_topping')
            ->withPivot('position', 'price');
    }
}
