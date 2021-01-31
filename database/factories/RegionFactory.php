<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Region::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(10)
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Region $region) {
            Driver::factory()->count(1)->for($region)->create();
        });
    }
}
