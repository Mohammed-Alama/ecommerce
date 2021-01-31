<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Driver extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'region_id',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function region()
    {
        return $this->belongsTo(
            'App\Models\Region',
            'region_id',
            'id'
        );
    }
    public function orders()
    {
        return $this->hasMany(
            'App\Models\Order',
            'driver_id',
            'id'
        );
    }
}
