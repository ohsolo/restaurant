<?php

namespace Database\Seeders;

use App\Models\Rider;
use Illuminate\Database\Seeder;

class RiderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rider::factory()->count(rand(80, 250))->create();
    }
}
