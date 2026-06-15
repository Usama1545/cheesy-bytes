<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountySeo extends Model
{
    use HasFactory;
    protected $table = 'county_seo';
    protected $fillable = ['county','category','content', 'branch_id', 'category_id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
