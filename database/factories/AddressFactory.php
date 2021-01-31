<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\City;
use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->address,
            'city_id' => City::inRandomOrder()->first()->id,
            'region_id' => Region::inRandomOrder()->first()->id,
        ];
    }
}
