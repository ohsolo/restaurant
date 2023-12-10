<?php

namespace Database\Factories;

use App\Models\Region;
use App\Models\Rider;
use Illuminate\Database\Eloquent\Factories\Factory;

class RiderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $vehicle_types  = ['car', 'bike', 'bicycle'];
        return [
            'rider_id'      => $this->faker->uuid,
            'name'          => $this->faker->name,
            'email'         => $this->faker->unique()->safeEmail,
            'phone'         => "0345-3910005",
            'password'      => \Hash::make('123456'),
            'cpf'           => '3232.3323.2323',
            'vehicle_type'  => $vehicle_types[$this->faker->numberBetween(0, 2)],
            'region_id'     => Region::inRandomOrder()->first()->region_id,
            'flags'         => Rider::FLAG_ACTIVE
        ];
    }
}
