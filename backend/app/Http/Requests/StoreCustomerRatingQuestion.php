<?php

namespace App\Http\Requests;

class StoreCustomerRatingQuestion extends ApiRequest
{
    public function rules()
    {
        return [
            'text' => 'bail|required|string'
        ];
    }
}
