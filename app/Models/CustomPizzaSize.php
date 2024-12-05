<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPizzaSize extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','price'];

    public function crusts()
    {
        return $this->hasMany(CustomPizzaCrust::class, 'size_id');
    }

    public function sauces()
    {
        return $this->hasMany(CustomPizzaSauce::class, 'size_id');
    }

    public function toppings()
    {
        return $this->hasMany(CustomPizzaTopping::class, 'size_id');
    }
}
