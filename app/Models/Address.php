<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'region_id',
        'city_id',
    ];


    public function user()
    {
        return $this->belongsTo(
            'App\Models\User',
            'user_id',
            'id'
        );
    }
    public function region()
    {
        return $this->belongsTo(
            'App\Models\Region',
            'region_id',
            'id'
        );
    }
    public function city()
    {
        return $this->belongsTo(
            'App\Models\City',
            'city_id',
            'id'
        );
    }
}
