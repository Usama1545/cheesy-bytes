<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PizzaPrice extends Model
{
    use HasFactory;

    protected $fillable = ['item_id','size_id','price','branch_id'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
