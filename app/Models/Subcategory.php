<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ApiCacheHelper;
use Illuminate\Support\Facades\Cache;
class Subcategory extends Model
{
    use HasFactory;
    protected $table='subcategories';
    protected $fillable=['name','cat_id','is_available','is_deleted'];

    protected static function booted()
    {
        static::saved(function ($subcategory) {
            $category = Category::find($subcategory->cat_id);
            if ($category) {
                ApiCacheHelper::clear("category_items_{$category->slug}");
                Cache::forget("category_items_base_{$category->slug}_branch_*");
            }
        });
    }
    public function category_info(){
        return $this->hasOne('App\Models\Category','id','cat_id')->select('categories.id','categories.category_name',\DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/category/')."/', image) AS image_url"));
    }
}