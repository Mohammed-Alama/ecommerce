<?php

namespace App\Support\Order;

use App\Models\Order;
use Illuminate\Support\Str;

class OrderStatusFactory
{

    public static function apply(string $status, Order $order)
    {
        $statuses = [
            'in_cart',
            'pending',
            'paid',
            'delivered',
            'returned',
            'cancelled'
        ];
        if (in_array($status, $statuses)) {
            $class_name = self::getStatusClassName($status);
            (new $class_name($status, $order))->apply();
        }
    }

    public static function getStatusClassName($status)
    {
        return "\\App\\Support\\Order\\StatusAction\\" . Str::studly($status);
    }
}
