<?php

namespace App\Http\Controllers\API\Users;

use App\Models\Order;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;

class OrderProductController extends Controller
{

    public function index()
    {
        return response()->json(['data' => auth_factory('user')->orders]);
    }

    public function show(Order $order)
    {
        if (auth_factory('user')->orders->contains($order->id)) {
            return response()->json(['data' => $order]);
        }
        throw (new AuthorizationException());
    }

    public function store(OrderRequest $request)
    {
        $order_data = $request->except('products');
        $order =  auth_factory('user')->orders()->create($order_data);
        $products = $this->mapProducts($request->input('products'));
        $order->products()->attach($products);

        $sub_total = $order->products->sum(function ($pro) {
            return $pro->price * $pro->pivot->quantity;
        });

        $order->update([
            'subtotal' => $sub_total,
            'total' => $sub_total + $order->fees
        ]);

        return response()->json([
            'message' => 'Order Created Successfully',
            'date' => $order
        ]);
    }

    public function update(OrderRequest $request, Order $order)
    {
        $order_data = $request->except('products');
        $order->update($order_data);
        $products = $this->mapProducts($request->input('products'));
        $order->products()->sync($products);

        $sub_total = $order->products->sum(function ($pro) {
            return $pro->price * $pro->pivot->quantity;
        });

        $order->update([
            'subtotal' => $sub_total,
            'total' => $sub_total + $order->fees
        ]);

        return response()->json([
            'message' => 'Order Updated Successfully',
            'date' => $order
        ]);
    }

    public function destroy(Order $order)
    {
        if ($order->user_id == auth_factory('user')->id) {
            throw (new AuthorizationException());
        }
        $order->delete();

        return response()->json([
            'message' => 'Order Deleted Successfully',
        ]);
    }

    protected function mapProducts($products)
    {
        return collect($products)->mapWithKeys(function ($product) {
            return [$product['id'] => ['quantity' => $product['quantity']]];
        });
    }
}
