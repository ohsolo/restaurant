<?php

namespace App\Http\Requests;

class StoreBranch extends ApiRequest
{
    public function rules()
    {
        return [
            'region_id' => 'required|string',
            'location' => 'required|string',
            'phone' => 'required|string',
            'city_id' => 'required|string',
            'value' => 'required',
            'country_id' => 'required|integer',
            'city_name' => 'required|string',
            'neighbourhood_id' => 'required|string',
        ];
    }
}
