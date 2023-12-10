<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

use App\Models\Setting;
class AddRiderReturnFeeInSettingsTable extends Migration
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
        $setting->title = "rider_return_fee";
        $setting->values = "0";
        $setting->save();
        
        $setting = new Setting;
        $setting->setting_id = Str::uuid();
        $setting->title = "platform_fee_percentage_for_deliverer_per_ride";
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
        Setting::where('title', 'rider_return_fee')->orWhere('title', 'platform_fee_percentage_for_deliverer_per_ride')->delete();
      
    }
}
