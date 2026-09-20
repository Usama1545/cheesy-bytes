<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ApiCacheHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
class TopDeals extends Model
{
    use HasFactory;
    protected $fillable = ['product_id','offer_type','deal_type','offer_amount','start_date','end_date','start_time','end_time','size_id','product_ids','min_count','order','bmsm_deal_type','slug','web_image','mobile_image','custom_message'];
    protected $table = 'top_deals';

    protected static function booted()
    {
        static::saved(function ($deal) {
            ApiCacheHelper::clear('deals');
            Log::info('Deals cache cleared after save');
        });

        static::deleted(function ($deal) {
            ApiCacheHelper::clear('deals');
            Log::info('Deals cache cleared after delete');
        });
    }

    /**
     * Whether the given item is part of the given deal (used to let deal-only,
     * deactivated products load when requested through their own deal).
     */
    public static function containsItem($dealId, $itemId): bool
    {
        if (!$dealId) {
            return false;
        }

        $deal = static::find($dealId);
        if (!$deal) {
            return false;
        }

        if ($deal->deal_type == 3) {
            return DealItem::where('deal_id', $deal->id)->where('item_id', $itemId)->exists();
        }

        if ($deal->deal_type == 4) {
            return BmsmDealProduct::where('deal_id', $deal->id)->where('item_id', $itemId)->exists();
        }

        return in_array((string) $itemId, explode(',', (string) $deal->product_ids), true);
    }

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
