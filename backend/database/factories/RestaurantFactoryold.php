<?php

namespace Database\Factories;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class RestaurantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Restaurant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rest_id' => $this->faker->uuid,
            'name' => $this->faker->company,
            'social_reason' => $this->faker->name,
            'cnpj' => $this->faker->phoneNumber,
            'neighbourhood' => $this->faker->name,
            'cep' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phones' => json_encode([$this->faker->phoneNumber]),
            'logo'  => $this->faker->imageUrl(150, 150),
            'total_rating' => $this->faker->numberBetween(1,5),
            'balance' => $this->faker->randomNumber(),
            'password' => Hash::make('123456'), // password
            'flags' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ];
    }
}
