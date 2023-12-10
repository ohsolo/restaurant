<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Country;
use App\Models\Region;
use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country = Country::where('iso', 'PK')->first();
        Region::factory()->has(
            City::factory()
                    ->count(rand(10, 25))
                    ->state(function (array $attributes, Region $region) use ($country) { 
                        return [
                            'region_id'  => $region->region_id,
                            'country_id' => $country->id
                        ];
                    }),
        )
        ->has(
            Address::factory()
                    ->count(rand(50, 100))
                    ->state(function (array $attributes, Region $region) use ($country) {
                        return [
                            'region_id' => $region->region_id,
                            'country_id' => $country->id
                        ];
                    })
        )->count(100)->create();
        // $faker = \Faker\Factory::create();
        // Country::where('iso', 'pk')->get()->map(function($country) use($faker) {
        //     for($i = 0; $i <= 10; $i++ ) {
        //         $region = Region::create([
        //             'region_id'     => Str::uuid(),
        //             'country_id'    => $country->id,
        //             'title'         => $faker->city,
        //             'flags'         => 1
        //         ]);
                
        //         for ($x=0; $x < 100; $x++) { 
        //             Address::create([
        //                 'address_id'    => Str::uuid(),
        //                 'country_id'    => $country->id,
        //                 'region_id'     => $region->region_id,
        //                 'location'      => $faker->streetName . $faker->streetAddress,
        //                 'latitude'      => $faker->latitude($min = 23, $max = 35), //'24.9006875',
        //                 'longitude'     => $faker->longitude($min = 60, $max = 77), //'67.0742255'
        //             ]);
        //         }
        //     }
        // });
    }
}
