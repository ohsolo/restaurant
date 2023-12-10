<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\UpdateSetting as UpdateSettingRequest;
use App\Http\Requests\UpdateSettingPageTwo as UpdateSettingPageTwoRequest;

use App\Models\Setting;

class SettingController extends Controller
{
    public function index ()
    {
        $settings = Setting::all();
        $combined_array = array();

        foreach ($settings as $value) {
            $combined_array[$value->title] = $value->values;

        }
        return api_success('Setting Data', $combined_array);
    }

    public function update_page_one (UpdateSettingRequest $request)
    {

        if ($request->has('sent_to_all_delivers_who_are_within_radius') && $request->filled('sent_to_all_delivers_who_are_within_radius') && $request->has('send_in_an_individual_and_orderly_way_to_the_deliverers_who_will_be_within_the_radius') && $request->filled('send_in_an_individual_and_orderly_way_to_the_deliverers_who_will_be_within_the_radius')) {
            $setting_sent_to_all_delivers_who_are_within_radius = Setting::where('title' , 'sent_to_all_delivers_who_are_within_radius')->first();

            $setting_send_in_an_individual_and_orderly_way_to_the_deliverers_who_will_be_within_the_radius = Setting::where('title' , 'send_in_an_individual_and_orderly_way_to_the_deliverers_who_will_be_within_the_radius')->first();

            if ($request->sent_to_all_delivers_who_are_within_radius == 1) {
                $setting_sent_to_all_delivers_who_are_within_radius->values = 1;
                $setting_send_in_an_individual_and_orderly_way_to_the_deliverers_who_will_be_within_the_radius->values = 0;

            } else {
                $setting_sent_to_all_delivers_who_are_within_radius->values = 0;
                $setting_send_in_an_individual_and_orderly_way_to_the_deliverers_who_will_be_within_the_radius->values = 1;
            }
            $setting_sent_to_all_delivers_who_are_within_radius->save();
            $setting_send_in_an_individual_and_orderly_way_to_the_deliverers_who_will_be_within_the_radius->save();
        }

        if ($request->has('maximum_distance_to_travel_per_delivery_for_bike') && $request->filled('maximum_distance_to_travel_per_delivery_for_bike')) {
            $setting = Setting::where('title' , 'maximum_distance_to_travel_per_delivery_for_bike')->first();
            $setting->values = $request->maximum_distance_to_travel_per_delivery_for_bike;
            $setting->save();
        }
        
        if ($request->has('maximum_distance_to_travel_per_delivery_for_car') && $request->filled('maximum_distance_to_travel_per_delivery_for_car')) {
            $setting = Setting::where('title' , 'maximum_distance_to_travel_per_delivery_for_car')->first();
            $setting->values = $request->maximum_distance_to_travel_per_delivery_for_car;
            $setting->save();
        }
        
        if ($request->has('maximum_distance_to_travel_per_delivery_for_bicycle') && $request->filled('maximum_distance_to_travel_per_delivery_for_bicycle')) {
            $setting = Setting::where('title' , 'maximum_distance_to_travel_per_delivery_for_bicycle')->first();
            $setting->values = $request->maximum_distance_to_travel_per_delivery_for_bicycle;
            $setting->save();
        }
        
        if ($request->has('maximum_distance_for_reception_of_alert_for_bicycle_per_km') && $request->filled('maximum_distance_for_reception_of_alert_for_bicycle_per_km')) {
            $setting = Setting::where('title' , 'maximum_distance_for_reception_of_alert_for_bicycle_per_km')->first();
            $setting->values = $request->maximum_distance_for_reception_of_alert_for_bicycle_per_km;
            $setting->save();
        }

        if ($request->has('maximum_distance_for_reception_of_alert_for_bike_per_km') && $request->filled('maximum_distance_for_reception_of_alert_for_bike_per_km')) {
            $setting = Setting::where('title' , 'maximum_distance_for_reception_of_alert_for_bike_per_km')->first();
            $setting->values = $request->maximum_distance_for_reception_of_alert_for_bike_per_km;
            $setting->save();
        }

        if ($request->has('maximum_distance_for_reception_of_alert_for_car_per_km') && $request->filled('maximum_distance_for_reception_of_alert_for_car_per_km')) {
            $setting = Setting::where('title' , 'maximum_distance_for_reception_of_alert_for_car_per_km')->first();
            $setting->values = $request->maximum_distance_for_reception_of_alert_for_car_per_km;
            $setting->save();
        }

        if ($request->has('maximum_orders_per_delivery_person_for_bicycle') && $request->filled('maximum_orders_per_delivery_person_for_bicycle')) {
            $setting = Setting::where('title' , 'maximum_orders_per_delivery_person_for_bicycle')->first();
            $setting->values = $request->maximum_orders_per_delivery_person_for_bicycle;
            $setting->save();
        }

        if ($request->has('maximum_orders_per_delivery_person_for_bike') && $request->filled('maximum_orders_per_delivery_person_for_bike')) {
            $setting = Setting::where('title' , 'maximum_orders_per_delivery_person_for_bike')->first();
            $setting->values = $request->maximum_orders_per_delivery_person_for_bike;
            $setting->save();
        }

        if ($request->has('maximum_orders_per_delivery_person_for_car') && $request->filled('maximum_orders_per_delivery_person_for_car')) {
            $setting = Setting::where('title' , 'maximum_orders_per_delivery_person_for_car')->first();
            $setting->values = $request->maximum_orders_per_delivery_person_for_car;
            $setting->save();
        }
        
        if ($request->has('only_bring_broken_orders_to_the_same_address') && $request->filled('only_bring_broken_orders_to_the_same_address')) {
            $setting = Setting::where('title' , 'only_bring_broken_orders_to_the_same_address')->first();
            $setting->values = $request->only_bring_broken_orders_to_the_same_address;
            $setting->save();
        }

        if ($request->has('allow_to_bring_orders_from_different_addresses') && $request->filled('allow_to_bring_orders_from_different_addresses')) {
            $setting = Setting::where('title' , 'allow_to_bring_orders_from_different_addresses')->first();
            $setting->values = $request->allow_to_bring_orders_from_different_addresses;
            $setting->save();
        }

        return api_success1('Settings Updated!');
    }

    
    public function update_page_two (UpdateSettingPageTwoRequest $request)
    {

        if ($request->has('values_by_distance_traveled_0_5_km') && $request->filled('values_by_distance_traveled_0_5_km')) {
            $setting = Setting::where('title' , 'values_by_distance_traveled_0_5_km')->first();
            $setting->values = $request->input("values_by_distance_traveled_0_5_km");
            $setting->save();
        }

        if ($request->has('values_by_distance_traveled_1_0_km') && $request->filled('values_by_distance_traveled_1_0_km')) {
            $setting = Setting::where('title' , 'values_by_distance_traveled_1_0_km')->first();
            $setting->values = $request->input("values_by_distance_traveled_1_0_km");
            $setting->save();
        }

        if ($request->has('values_by_distance_traveled_1_5_km') && $request->filled('values_by_distance_traveled_1_5_km')) {
            $setting = Setting::where('title' , 'values_by_distance_traveled_1_5_km')->first();
            $setting->values = $request->input("values_by_distance_traveled_1_5_km");
            $setting->save();
        }

        if ($request->has('values_by_distance_traveled_2_0_km') && $request->filled('values_by_distance_traveled_2_0_km')) {
            $setting = Setting::where('title' , 'values_by_distance_traveled_2_0_km')->first();
            $setting->values = $request->input("values_by_distance_traveled_2_0_km");
            $setting->save();
        }

        if ($request->has('values_by_distance_traveled_2_5_km') && $request->filled('values_by_distance_traveled_2_5_km')) {
            $setting = Setting::where('title' , 'values_by_distance_traveled_2_5_km')->first();
            $setting->values = $request->input("values_by_distance_traveled_2_5_km");
            $setting->save();
        }

        if ($request->has('values_by_distance_traveled_3_0_km') && $request->filled('values_by_distance_traveled_3_0_km')) {
            $setting = Setting::where('title' , 'values_by_distance_traveled_3_0_km')->first();
            $setting->values = $request->input("values_by_distance_traveled_3_0_km");
            $setting->save();
        }

        if ($request->has('values_by_distance_traveled_3_5_km') && $request->filled('values_by_distance_traveled_3_5_km')) {
            $setting = Setting::where('title' , 'values_by_distance_traveled_3_5_km')->first();
            $setting->values = $request->input("values_by_distance_traveled_3_5_km");
            $setting->save();
        }

        if ($request->has('values_by_distance_traveled_4_0_km') && $request->filled('values_by_distance_traveled_4_0_km')) {
            $setting = Setting::where('title' , 'values_by_distance_traveled_4_0_km')->first();
            $setting->values = $request->input("values_by_distance_traveled_4_0_km");
            $setting->save();
        }

        if ($request->has('values_by_distance_traveled_4_5_km') && $request->filled('values_by_distance_traveled_4_5_km')) {
            $setting = Setting::where('title' , 'values_by_distance_traveled_4_5_km')->first();
            $setting->values = $request->input("values_by_distance_traveled_4_5_km");
            $setting->save();
        }

        if ($request->has('values_by_distance_traveled_5_0_km') && $request->filled('values_by_distance_traveled_5_0_km')) {
            $setting = Setting::where('title' , 'values_by_distance_traveled_5_0_km')->first();
            $setting->values = $request->input("values_by_distance_traveled_5_0_km");
            $setting->save();
        }

        if ($request->has('values_by_distance_traveled_5_5_km') && $request->filled('values_by_distance_traveled_5_5_km')) {
            $setting = Setting::where('title' , 'values_by_distance_traveled_5_5_km')->first();
            $setting->values = $request->input("values_by_distance_traveled_5_5_km");
            $setting->save();
        }

        if ($request->has('values_by_distance_traveled_6_0_km') && $request->filled('values_by_distance_traveled_6_0_km')) {
            $setting = Setting::where('title' , 'values_by_distance_traveled_6_0_km')->first();
            $setting->values = $request->input("values_by_distance_traveled_6_0_km");
            $setting->save();
        }

        if ($request->has('values_by_distance_traveled_6_5_km') && $request->filled('values_by_distance_traveled_6_5_km')) {
            $setting = Setting::where('title' , 'values_by_distance_traveled_6_5_km')->first();
            $setting->values = $request->input("values_by_distance_traveled_6_5_km");
            $setting->save();
        }

        if ($request->has('values_by_distance_traveled_7_0_km') && $request->filled('values_by_distance_traveled_7_0_km')) {
            $setting = Setting::where('title' , 'values_by_distance_traveled_7_0_km')->first();
            $setting->values = $request->input("values_by_distance_traveled_7_0_km");
            $setting->save();
        }

        if ($request->has('values_by_distance_traveled_7_5_km') && $request->filled('values_by_distance_traveled_7_5_km')) {
            $setting = Setting::where('title' , 'values_by_distance_traveled_7_5_km')->first();
            $setting->values = $request->input("values_by_distance_traveled_7_5_km");
            $setting->save();
        }

        if ($request->has('values_by_distance_traveled_8_0_km') && $request->filled('values_by_distance_traveled_8_0_km')) {
            $setting = Setting::where('title' , 'values_by_distance_traveled_8_0_km')->first();
            $setting->values = $request->input("values_by_distance_traveled_8_0_km");
            $setting->save();
        }

        if ($request->has('values_by_distance_traveled_8_5_km') && $request->filled('values_by_distance_traveled_8_5_km')) {
            $setting = Setting::where('title' , 'values_by_distance_traveled_8_5_km')->first();
            $setting->values = $request->input("values_by_distance_traveled_8_5_km");
            $setting->save();
        }

        if ($request->has('values_by_distance_traveled_9_0_km') && $request->filled('values_by_distance_traveled_9_0_km')) {
            $setting = Setting::where('title' , 'values_by_distance_traveled_9_0_km')->first();
            $setting->values = $request->input("values_by_distance_traveled_9_0_km");
            $setting->save();
        }

        if ($request->has('values_by_distance_traveled_9_5_km') && $request->filled('values_by_distance_traveled_9_5_km')) {
            $setting = Setting::where('title' , 'values_by_distance_traveled_9_5_km')->first();
            $setting->values = $request->input("values_by_distance_traveled_9_5_km");
            $setting->save();
        }

        if ($request->has('values_by_distance_traveled_10_0_km') && $request->filled('values_by_distance_traveled_10_0_km')) {
            $setting = Setting::where('title' , 'values_by_distance_traveled_10_0_km')->first();
            $setting->values = $request->input("values_by_distance_traveled_10_0_km");
            $setting->save();
        }

        if ($request->has('values_over_10_0_km_charge') && $request->filled('values_over_10_0_km_charge')) {
            $setting = Setting::where('title' , 'values_over_10_0_km_charge')->first();
            $setting->values = $request->input("values_over_10_0_km_charge");
            $setting->save();
        }

        if ($request->has('charge_return_tax') && $request->filled('charge_return_tax')) {
            $setting = Setting::where('title' , 'charge_return_tax')->first();
            $setting->values = $request->input("charge_return_tax");
            $setting->save();
        }

        if ($request->has('return_tax_to_establishment') && $request->filled('return_tax_to_establishment')) {
            $setting = Setting::where('title' , 'return_tax_to_establishment')->first();
            $setting->values = $request->input("return_tax_to_establishment");
            $setting->save();
        }
       
        if ($request->has('rider_return_fee') && $request->filled('rider_return_fee')) {
            $setting = Setting::where('title' , 'rider_return_fee')->first();
            $setting->values = $request->input("rider_return_fee");
            $setting->save();
        }

        if ($request->has('platform_fee_percentage_for_deliverer_per_ride') && $request->filled('platform_fee_percentage_for_deliverer_per_ride')) {
            $setting = Setting::where('title' , 'platform_fee_percentage_for_deliverer_per_ride')->first();
            $setting->values = $request->input("platform_fee_percentage_for_deliverer_per_ride");
            $setting->save();
        }
        return api_success1('Settings Updated!');

    }
}
