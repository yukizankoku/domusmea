<?php

namespace App\Models;

use App\Observers\PropertyObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(PropertyObserver::class)]

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'image' => 'array',
        'amenities' => 'array',
        'features' => 'array'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($property) {
            $property->code = $property->code ?? self::generateCode();
        });
    }

    // Membuat fungsi generateCode dengan 6 angka
    public static function generateCode()
    {
        $lastProperty = self::latest('id')->first();
        $nextId = $lastProperty ? $lastProperty->id + 1 : 1;

        return sprintf('DM-%06d', $nextId);
    }

    public function getRouteKeyName()
    {
        return 'code';
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'sold_by');
    }    

    public function lister()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }    

    public function commission()
    {
        return $this->hasOne(Commission::class, 'property_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'provinces_id');
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class, 'regencies_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'districts_id');
    }


    public function village()
    {
        return $this->belongsTo(Village::class, 'villages_id');
    }

    protected static function booted()
    {
        static::creating(function ($property) {
            $property->posted_by = Auth::id();
        });

        static::updating(function ($property) {
            if (!$property->posted_by) {
                $property->posted_by = Auth::id();
            }
        });
    }
}
