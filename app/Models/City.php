<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function regions()
    {
        return $this->hasMany(
            'App\Models\Region',
            'city_id',
            'id'
        );
    }
}
