<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => $this->faker->randomElement($this->orderStatus()),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            $driver_id = Driver::select('id')->whereRegionId($order->address->region_id)->first()->id;
            $order->update([
                'driver_id' => $driver_id
            ]);
            $products = Product::inRandomOrder()
                ->limit(5)
                ->select('id')
                ->get()
                ->mapWithKeys(function ($pro) {
                    return [$pro->id => ['quantity' => random_int(1, 10)]];
                });
            $order->products()->attach($products);

            $sub_total = $order->products->sum(function ($pro) {
                return $pro->price * $pro->pivot->quantity;
            });

            $fees = random_int(30, 200);
            $order->update([
                'fees' => $fees,
                'subtotal' => $sub_total,
                'total' => $sub_total + $fees
            ]);
        });
    }

    protected function orderStatus()
    {
        return [
            'in_cart',
            'pending',
            'paid',
            'delivered',
            'returned',
            'cancelled'
        ];
    }
}
