<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\City;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'phone' => $this->faker->regexify('/^201[0-2-5]{1}[0-9]{8}/'),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $city = City::inRandomOrder()->first();
            $region = $city->regions->random();
            $address =  Address::factory()
                ->count(1)
                ->for($user)
                ->for($city)
                ->for($region)
                ->create();

            Order::factory()
                ->count(1)
                ->for($user)
                ->for($address->first())
                ->create();
        });
    }
}
