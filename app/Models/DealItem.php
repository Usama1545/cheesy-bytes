<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealItem extends Model
{
    use HasFactory;

    protected $table = 'deal_items';

    protected $fillable = [
        'deal_id',
        'item_id',
        'deal_category_id',
    ];

    public function deal()
    {
        return $this->belongsTo(TopDeals::class, 'deal_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function dealCategory()
    {
        return $this->belongsTo(DealCategory::class);
    }
}
