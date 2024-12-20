<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPizzaSelectedDipping extends Model
{
    use HasFactory;

    protected $fillable = ['dipping_id','pizza_id','quantity'];

    public function dipping()
    {
        return $this->belongsTo(Sides::class, 'dipping_id');
    }
}
