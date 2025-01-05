<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrier extends Model
{
    use HasFactory;
     protected $fillable = ['branch_id','link','name','image','reorder_id'];

     public function branch()
     {
         return $this->belongsTo(Branch::class);
     }
}
