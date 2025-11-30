<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealCategory extends Model
{
    use HasFactory;

    protected $table = 'deal_categories';
    protected $fillable = [
        'deal_id',
        'category_id',
        'is_free',
        'is_required',
        'quantity',
        'unique_products',
        'size_id',
    ];

    public function deal()
    {
        return $this->belongsTo(TopDeals::class, 'deal_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function dealItem()
    {
        return $this->hasMany(DealItem::class, 'deal_category_id', 'id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id', 'id');
    }

    
    public function scopeRequired($query)
    {
        return $query->where('is_required', 1);
    }

    public function scopeFree($query)
    {
        return $query->where('is_free', 1);
    }

}
