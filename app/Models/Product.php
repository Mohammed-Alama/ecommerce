<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'is_active',
        'merchant_id'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->whereIsActive(true);
    }

    public function merchant()
    {
        return $this->belongsTo(
            'App\Models\Merchant',
            'merchant_id',
            'id'
        );
    }

    public function orders()
    {
        return $this->belongsToMany(
            'App\Models\Order',
            'order_product',
            'product_id',
            'order_id'
        )->withPivot('quantity');
    }
}
