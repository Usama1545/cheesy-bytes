<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PizzaTopping extends Model
{
    use HasFactory;

    protected $fillable = ['custom_pizza_id','topping_id','position','price'];
    public function customPizzas()
    {
        return $this->belongsToMany(CustomPizza::class, 'custom_pizza_topping')
            ->withPivot('position', 'price');
    }
}
