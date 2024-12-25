<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itemPrice extends Model
{
    use HasFactory;
    protected $table = 'item_prices';
    protected $fillable = ['item_id', 'price','branch_id'];

    public function product()
    {
        return $this->belongsTo(Item::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
