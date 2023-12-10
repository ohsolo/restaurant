<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $platform_fee_to_rider             = Setting::where('title', '=', 'platform_fee_percentage_for_deliverer_per_ride')->first();
        $platform_charges_to_restaurant    = Setting::where('title', '=', 'platform_charges_to_restaurant')->first();
        $platform_charges_to_rider         = rand(100, 9999) * ($platform_fee_to_rider->values / 100);
        $amount                            = rand(100, 9999);
        $order_methods                     = ['app','email','phone','whatsapp'];
        $order_payment_methods             = [Order::PAYMENT_ONLINE, Order::PAYMENT_CASH_ON_DELIVERY];
        
        return [
            'order_id'                              => Str::uuid(),
            'order_number'                          => Order::count() + 1000,
            'address_id'                            => Address::inRandomOrder()->first()->address_id,
            'output_time'                           => rand(1,24) . ":" . rand(0,59) . ":" . rand(0,59),
            'order_method'                          => $order_methods[rand(0, 3)],
            'payment_method'                        => $order_payment_methods[rand(0, 1)],
            'dishes_info'                           => $this->faker->words($this->faker->numberBetween(3, 10), true) ,
            'observations'                          => $this->faker->sentence($this->faker->numberBetween(1, 10), true),
            'remarks'                               => $this->faker->sentence($this->faker->numberBetween(1, 10), true),
            'compliments'                           => $this->faker->sentence($this->faker->numberBetween(1, 10), true),
            'comments'                              => $this->faker->sentence($this->faker->numberBetween(1, 10), true),
            'response'                              => $this->faker->sentence($this->faker->numberBetween(1, 10), true),
            'customer_info'                         => $this->faker->name(),
            'delivery_charges'                      => $amount,
            'gross_profit'                          => $amount * 0.10,
            'net_profit'                            => $amount * 0.20,
            'rest_order_amount'                     => $amount * 0.8,
            'total_distance'                        => $this->faker->randomFloat(2, 1, 11),
            'platform_charges_to_rider'             => $platform_charges_to_rider,
            'platform_charges_to_restaurant'        => $platform_charges_to_restaurant->values,
            'status'                                => Order::STATUS_RESEARCH,
            'rider_return_fee'                      => Setting::where('title', 'rider_return_fee')->first()->value ?? 10.0
        ];
    }
}
