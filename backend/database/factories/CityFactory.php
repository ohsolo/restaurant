<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = City::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'city_id'    => Str::uuid(),
            'lat'        => $this->faker->latitude(23, 35),
            'long'       => $this->faker->longitude(65, 75),
            'city_name'  => $this->faker->city
        ];
    }
}
