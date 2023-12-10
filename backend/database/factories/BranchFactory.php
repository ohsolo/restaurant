<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BranchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Branch::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'branch_id'     => Str::uuid(),
            'city_id'       => City::inRandomOrder()->first()['city_id'],
            'location'      => $this->faker->address,
            'latitude'      => $this->faker->latitude($min = 23, $max = 24), //'24.9006875',
            'longitude'     => $this->faker->longitude($min = 66, $max = 67), //'67.0742255'
            'flags'          => 1
        ];
    }
}
