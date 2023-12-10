<?php

namespace App\Http\Requests;

class StoreRiderRatingQuestion extends ApiRequest
{
    public function rules()
    {
        return [
            'text' => 'bail|required|string'
        ];
    }
}
