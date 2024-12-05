<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddonsGroup extends Model
{
    protected $table = 'addons_group';
    protected $fillable = ['name', 'selection_type', 'selection_count', 'min_count', 'max_count'];
    public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'cat_id');
    }
    public function item()
    {
        return $this->hasOne('App\Models\Item', 'id', 'item_id');
    }
}
