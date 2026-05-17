<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BmsmDealProduct extends Model
{
    use HasFactory;

    protected $table = 'bmsm_deal_products';

    protected $fillable = [
        'deal_id', 'item_id'
    ];

    public function deal()
    {
        return $this->belongsTo(TopDeals::class);
    }

    public function product()
    {
        return $this->belongsTo(Item::class);
    }
}
