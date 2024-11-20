<?php

namespace App\Models;

use Filament\Panel;

use App\Observers\UserObserver;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(UserObserver::class)]

class User extends Authenticatable implements MustVerifyEmail, FilamentUser
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasVerifiedEmail();
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function seller()
    {
        return $this->hasMany(Property::class, 'sold_by');
    }    

    public function lister()
    {
        return $this->hasMany(Property::class, 'posted_by');
    }    

    public function sellerCommission()
    {
        return $this->hasMany(Commission::class, 'sold_by');
    }    

    public function listerCommission()
    {
        return $this->hasMany(Commission::class, 'posted_by');
    }    

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }

    public function setPasswordAttribute($value)
    {
        // Enkripsi password hanya jika nilai diberikan
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }
    
}
