<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'pembayaran' => 'array',
    ];

    public function property()
    {
        return $this->hasOne(Property::class);
    }

    public function sellerCommission()
    {
        return $this->belongsTo(User::class, 'sold_by');
    }    

    public function listerCommission()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }    
}
