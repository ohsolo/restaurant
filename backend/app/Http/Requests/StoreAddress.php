<?php

namespace App\Http\Requests;

class StoreAddress extends ApiRequest
{
    public function rules()
    {
        return [
            'neighbourhood_id' => 'bail|required|string',
            'country_id' => 'bail|required|integer',
            'region_id' => 'bail|required|string',
            'location' => 'bail|required|string'
        ];
    }
}
