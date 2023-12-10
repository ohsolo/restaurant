<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Setting;

class AddSomeFieldsInSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "maximum_distance_to_travel_per_delivery_for_bike";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "maximum_distance_to_travel_per_delivery_for_car";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "maximum_distance_to_travel_per_delivery_for_bicycle";
        $setting->values = "0";
        $setting->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Setting::where('title', 'maximum_distance_to_travel_per_delivery_for_bike')->orWhere('title', 'maximum_distance_to_travel_per_delivery_for_car')->orWhere('title', 'maximum_distance_to_travel_per_delivery_for_bicycle')->delete();
    }
}
