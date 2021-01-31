<?php

namespace App\Http\Controllers\API\Drivers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Support\Order\OrderStatusFactory;
use Illuminate\Auth\Access\AuthorizationException;

class OrderUpdateStatusController extends Controller
{
    public function __invoke(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:delivered,returned']);
        if ($order->address->region_id == auth_factory('user')->region_id) {
            OrderStatusFactory::apply($request->input('status'), $order);
            return response()->json(['message' => 'Order Stauts updated to ' . $order->status]);
        }

        throw (new AuthorizationException());
    }
}
