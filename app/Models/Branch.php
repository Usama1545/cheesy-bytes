<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'address',
        'city',
        'state_id',
        'zip',
        'printer_id',
        'mac_id'
    ];
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->slug = Str::slug($model->name);
        });

        static::updating(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function paymentMethod()
    {
        return $this->hasOne(Payment::class, 'branch_id', 'id')
            ->where('is_activate', '1')
            ->select('branch_id', 'public_key', 'secret_key');
    }

    public function delivery_partners()
    {
        return $this->hasMany(Carrier::class, 'branch_id', 'id');
    }

}
