<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterFeatures extends Model
{
    protected $table='footer_features';
    protected $fillable=['id','icon','title','description'];
}
