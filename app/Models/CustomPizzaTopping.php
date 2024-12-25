<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPizzaTopping extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','price','size_id','branch_id'];

    public function size()
    {
        return $this->belongsTo(CustomPizzaSize::class, 'size_id');
    }
}
