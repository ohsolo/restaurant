<?php

namespace App\Http\Requests;

class UpdateSettingPageTwo extends ApiRequest
{
    public function authorize()
    {
        if (request()->admin) return true;

        return false;
    }

    public function rules()
    {
        return [
            "values_by_distance_traveled_0_5_km" => 'bail|required',
            "values_by_distance_traveled_1_0_km" => 'bail|required',
            "values_by_distance_traveled_1_5_km" => 'bail|required',
            "values_by_distance_traveled_2_0_km" => 'bail|required',
            "values_by_distance_traveled_2_5_km" => 'bail|required',
            "values_by_distance_traveled_3_0_km" => 'bail|required',
            "values_by_distance_traveled_3_5_km" => 'bail|required',
            "values_by_distance_traveled_4_0_km" => 'bail|required',
            "values_by_distance_traveled_4_5_km" => 'bail|required',
            "values_by_distance_traveled_5_0_km" => 'bail|required',
            "values_by_distance_traveled_5_5_km" => 'bail|required',
            "values_by_distance_traveled_6_0_km" => 'bail|required',
            "values_by_distance_traveled_6_5_km" => 'bail|required',
            "values_by_distance_traveled_7_0_km" => 'bail|required',
            "values_by_distance_traveled_7_5_km" => 'bail|required',
            "values_by_distance_traveled_8_0_km" => 'bail|required',
            "values_by_distance_traveled_8_5_km" => 'bail|required',
            "values_by_distance_traveled_9_0_km" => 'bail|required',
            "values_by_distance_traveled_9_5_km" => 'bail|required',
            "values_by_distance_traveled_10_0_km" => 'bail|required',
            "values_over_10_0_km_charge" => 'bail|required',
            "charge_return_tax" => 'bail|required|boolean',
            "return_tax_to_establishment" => 'bail|required'
        ];
    }
}
