<?php

namespace App\Http\Controllers\API\Drivers;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::whereHas('address', function ($query) {
            $query->where('region_id', auth_factory('user')->region_id);
        })->get();

        return response()->json([
            'data' => $orders
        ]);
    }

    public function listOrders()
    {
        return response()->json([
            'data' => auth_factory('user')->orders
        ]);
    }

    public function assignOrder(Order $order)
    {
        if (!is_null($order->driver_id)) {
            return response()->json([
                'message' => 'This Order Belong To Another Driver'
            ]);
        }

        if ($order->address->region_id == auth_factory('user')->region_id) {
            $order->update(['driver_id' => auth_factory('user')->id]);
            return response()->json([
                'message' => 'Now this Order belongs to you Take care of it'
            ]);
        } else {
            return response()->json([
                'message' => 'This Order not in your area'
            ], 422);
        }
    }
}
