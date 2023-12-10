<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Country;
use Illuminate\Support\Str;
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
            'address_id'    => Str::uuid(),
            'location'      => $this->faker->streetName . $this->faker->streetAddress,
            'latitude'      => $this->faker->latitude($min = 23, $max = 35), //'24.9006875',
            'longitude'     => $this->faker->longitude($min = 60, $max = 77), //'67.0742255'
        ];
    }
}
