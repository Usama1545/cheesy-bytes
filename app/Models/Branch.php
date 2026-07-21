<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
        'mac_id',
        'webhook_secret',
        'is_mobile',
        'is_web',
        'seo_name'
    ];

    protected $casts = [
        'is_mobile' => 'boolean',
        'is_web' => 'boolean'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->slug = Str::slug($model->name);
        });

        static::created(function ($branch) {
            $templateBranchId = DB::table('time')
                ->select('branch_id')
                ->groupBy('branch_id')
                ->havingRaw('COUNT(*) >= 7')
                ->orderBy('branch_id')
                ->value('branch_id');

            if (!$templateBranchId) {
                return;
            }

            DB::table('time')->insertUsing(
                ['branch_id', 'day', 'open_time', 'break_start', 'break_end', 'close_time', 'always_close'],
                DB::table('time')
                    ->selectRaw('?, day, open_time, break_start, break_end, close_time, always_close', [$branch->id])
                    ->where('branch_id', $templateBranchId)
                    ->orderBy('id')
                    ->limit(7)
            );
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

    public function time()
    {
        return $this->hasMany(Time::class, 'branch_id', 'id');
    }
}
