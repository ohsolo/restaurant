<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Setting;

class AddRowInSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $setting = new Setting;
        $setting->setting_id = Str::uuid();
        $setting->title = "platform_charges_to_restaurant";
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
        Setting::where('title', 'platform_charges_to_restaurant')->delete();

    }
}
