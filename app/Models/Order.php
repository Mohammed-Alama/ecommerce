<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'total',
        'subtotal',
        'fees',
        'paid',
        'purchased_at',
        'user_id',
        'address_id',
        'driver_id',
    ];

    public function user()
    {
        return $this->belongsTo(
            'App\Models\User',
            'user_id',
            'id'
        );
    }

    public function driver()
    {
        return $this->belongsTo(
            'App\Models\Driver',
            'driver_id',
            'id'
        );
    }

    public function address()
    {
        return $this->belongsTo(
            'App\Models\Address',
            'address_id',
            'id'
        );
    }

    public function products()
    {
        return $this->belongsToMany(
            'App\Models\Product',
            'order_product',
            'order_id',
            'product_id'
        )->withPivot('quantity');
    }
}
