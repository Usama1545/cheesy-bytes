<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterFeatures extends Model
{
    protected $table='footer_features';
    protected $fillable=['id','branch_id','title','description','number','email','address'];
}
