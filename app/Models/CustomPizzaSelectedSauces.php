<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPizzaSelectedSauces extends Model
{
    use HasFactory;

    protected $table = 'custom_pizza_selected_sauces';
    protected $fillable = ['sauce_id','pizza_id','side','quantity'];

}
