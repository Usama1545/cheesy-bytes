<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class RefundPolicy extends Model
{
    protected $table='refundpolicy';
    protected $fillable=['refundpolicy_content'];
}