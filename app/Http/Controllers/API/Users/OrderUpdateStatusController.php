<?php

namespace App\Http\Controllers\API\Users;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Support\Order\OrderStatusFactory;

class OrderUpdateStatusController extends Controller
{

    public function __invoke(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,paid,cancelled']);
        OrderStatusFactory::apply($request->input('status'), $order);
        return response()->json(['message' => 'Order Stauts updated to ' . $order->status]);
    }
}
