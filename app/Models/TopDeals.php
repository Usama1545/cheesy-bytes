<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopDeals extends Model
{
    use HasFactory;
    protected $fillable = ['product_id','offer_type','deal_type','offer_amount','start_date','end_date','start_time','end_time','size_id','product_ids','min_count','order','bmsm_deal_type','slug'];
    protected $table = 'top_deals';
    public function product()
    {
        return $this->belongsTo(Item::class,'product_id','id');
    }

    public function dealCategory()
    {
        return $this->hasMany(DealCategory::class, 'deal_id', 'id');
    }

    public function dealItem()
    {
        return $this->hasMany(DealItem::class, 'deal_id', 'id');
    }

    public function bmsmTiers()
    {
        return $this->hasMany(BmsmDealTier::class, 'deal_id', 'id');
    }

    public function bmsmProducts()
    {
        return $this->hasMany(BmsmDealProduct::class, 'deal_id', 'id');
    }

}
