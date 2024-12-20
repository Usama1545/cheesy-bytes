<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopDeals extends Model
{
    use HasFactory;
    protected $fillable = ['product_id','offer_type','offer_amount','start_date','end_date','start_time','end_time'];
    protected $table = 'top_deals';
    public function product()
    {
        return $this->belongsTo(Item::class,'product_id','id');
    }
}
