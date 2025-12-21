<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ApiCacheHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
class Slider extends Model
{
    protected $table='slider';
    protected $fillable=['image','title','description','branch_id'];

    protected static function booted()
    {
        static::saved(function ($slider) {
            // Clear sliders cache for the specific branch
            ApiCacheHelper::clear('sliders');
            Log::info('Sliders cache cleared after save for branch: ' . $slider->branch_id);
        });
        
        static::deleted(function ($slider) {
            ApiCacheHelper::clear('sliders');
            Log::info('Sliders cache cleared after delete for branch: ' . $slider->branch_id);
        });
    }
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
