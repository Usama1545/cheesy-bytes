<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Banner extends Model
{
    protected $table='banner';
    protected $fillable=['image','branch_id'];
    public function item_info(){
        return $this->hasOne('App\Models\Item','id','item_id')->select('id','item_name','slug');
    }
    public function category_info(){
        return $this->hasOne('App\Models\Category','id','cat_id')->select('id','category_name','slug');
    }
}
