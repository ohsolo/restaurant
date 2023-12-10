<?php

namespace App\Http\Requests;

class UpdateSetting extends ApiRequest
{
    public function authorize()
    {
        if (request()->admin) return true;

        return false;
    }

    public function rules()
    {
        return [
            'sent_to_all_delivers_who_are_within_radius' => 'bail|required|boolean',
            'send_in_an_individual_and_orderly_way_to_the_deliverers_who_will_be_within_the_radius' => 'bail|required|boolean',
            'only_bring_broken_orders_to_the_same_address' => 'bail|required|boolean',
            'allow_to_bring_orders_from_different_addresses' => 'bail|required|boolean',
            
            'maximum_distance_for_reception_of_alert_for_bicycle_per_km' => 'bail|required',
            'maximum_distance_for_reception_of_alert_for_bike_per_km' => 'bail|required',
            'maximum_distance_for_reception_of_alert_for_car_per_km' => 'bail|required',
            
            'maximum_orders_per_delivery_person_for_bicycle' => 'bail|required',
            'maximum_orders_per_delivery_person_for_bike' => 'bail|required',
            'maximum_orders_per_delivery_person_for_car' => 'bail|required',
        ];
    }
}
