<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Branch;
use App\Models\Order;
use Illuminate\Database\Seeder;
use App\Models\Restaurant;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Restaurant::factory()->has(
            Branch::factory()
                ->has(
                    Order::factory()
                    ->count(5)
                    ->state(function (array $attributes, Branch $branch)  {
                        return [
                            'branch_id' => $branch->branch_id,
                            'rest_id'   => $branch->rest_id
                        ];
                    })
                )
                ->count(5)
                ->state(function (array $attributes, Restaurant $restaurant)  {
                    return [
                        'rest_id' => $restaurant->rest_id
                    ];
                })
        )->count(10)->create();
    }
}
