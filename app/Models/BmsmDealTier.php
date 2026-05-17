<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BmsmDealTier extends Model
{
    use HasFactory;

    protected $table = 'bmsm_deal_tiers';

    protected $fillable = [
        'deal_id', 'min_qty', 'max_qty', 'min_spend', 'max_spend', 'discount_value'
    ];

    public function deal()
    {
        return $this->belongsTo(TopDeals::class);
    }
}
