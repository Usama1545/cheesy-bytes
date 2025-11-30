<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Slider extends Model
{
    protected $table='slider';
    protected $fillable=['image','title','description','branch_id'];
    public function item_info(){
        return $this->hasOne('App\Models\Item','id','item_id')->select('id','item_name','slug');
    }
    public function category_info(){
        return $this->hasOne('App\Models\Category','id','cat_id')->select('id','category_name','slug');
    }

    public function subcategory_info(){
        return $this->hasOne('App\Models\Subcategory','id','subcat_id')->select('id','subcategory_name','slug');
    }

    public function branch(){
        return $this->hasOne('App\Models\Branch','id','branch_id')->select('id','name','slug');
    }
}
