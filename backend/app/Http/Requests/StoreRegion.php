<?php

namespace App\Http\Requests;

class StoreRegion extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'country_id' => 'bail|required|integer',
            'title' => 'bail|required|string|unique:regions'
        ];
    }
}
