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
    protected $fillable = ['product_id','offer_type','deal_type','offer_amount','start_date','end_date','start_time','end_time','size_id','product_ids','min_count','order','bmsm_deal_type','slug'];
    protected $table = 'top_deals';

    protected static function booted()
    {
        static::saved(function ($deal) {
            // Clear all deals cache for all branches
            ApiCacheHelper::clear('deals');
            
            // Also clear by hour-based cache patterns
            $cache = Cache::getStore();
            $directory = $cache->getDirectory();
            $files = glob("{$directory}/" . md5('deals_branch_*') . '*');
            
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
            
            Log::info('Deals cache cleared after save');
        });
        
        static::deleted(function ($deal) {
            ApiCacheHelper::clear('deals');
            Log::info('Deals cache cleared after delete');
        });
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
