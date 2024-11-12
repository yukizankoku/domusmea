<?php

namespace App\Models;

use App\Observers\PortfolioObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(PortfolioObserver::class)]

class Portfolio extends Model
{
    use HasFactory , Sluggable, SoftDeletes;

    protected $guarded = ['id'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $casts = [
        'image' => 'array',
        'category' => 'array',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
