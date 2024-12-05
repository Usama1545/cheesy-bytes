<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Subcategory extends Model
{
    use HasFactory;
    protected $table='subcategories';
    protected $fillable=['name','cat_id','is_available','is_deleted'];
    public function category_info(){
        return $this->hasOne('App\Models\Category','id','cat_id')->select('categories.id','categories.category_name',\DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/category/')."/', image) AS image_url"));
    }
}