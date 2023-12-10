<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Setting;

class AddSettingsKeysAndValues extends Migration
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
        $setting->title = "sent_to_all_delivers_who_are_within_radius";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "send_in_an_individual_and_orderly_way_to_the_deliverers_who_will_be_within_the_radius";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "maximum_distance_for_reception_of_alert_for_bicycle_per_km";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "maximum_distance_for_reception_of_alert_for_bike_per_km";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "maximum_distance_for_reception_of_alert_for_car_per_km";
        $setting->values = "0";
        $setting->save();


        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "maximum_orders_per_delivery_person_for_bicycle";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "maximum_orders_per_delivery_person_for_bike";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "maximum_orders_per_delivery_person_for_car";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "only_bring_broken_orders_to_the_same_address";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "allow_to_bring_orders_from_different_addresses";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "values_by_distance_traveled_0_5_km";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "values_by_distance_traveled_1_0_km";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "values_by_distance_traveled_1_5_km";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "values_by_distance_traveled_2_0_km";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "values_by_distance_traveled_2_5_km";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "values_by_distance_traveled_3_0_km";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "values_by_distance_traveled_3_5_km";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "values_by_distance_traveled_4_0_km";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "values_by_distance_traveled_4_5_km";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "values_by_distance_traveled_5_0_km";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "values_by_distance_traveled_5_5_km";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "values_by_distance_traveled_6_0_km";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "values_by_distance_traveled_6_5_km";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "values_by_distance_traveled_7_0_km";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "values_by_distance_traveled_7_5_km";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "values_by_distance_traveled_8_0_km";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "values_by_distance_traveled_8_5_km";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "values_by_distance_traveled_9_0_km";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "values_by_distance_traveled_9_5_km";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "values_by_distance_traveled_10_0_km";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "values_over_10_0_km_charge";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "charge_return_tax";
        $setting->values = "0";
        $setting->save();

        $setting = new Setting;
        $setting->setting_id = (String) Str::uuid();
        $setting->title = "return_tax_to_establishment";
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
        DB::table('settings')->truncate();
    }
}
