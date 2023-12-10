<?php

namespace App\Http\Requests;

class StoreRestaurant extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'bail|required|string',
            'social_reason' => 'bail|required|string',
            'cnpj' => 'bail|required|string',
            'public_place' => 'bail|required|string',
            'neighbourhood' => 'bail|required|string',
            'cep' => 'bail|required|string',
            'email' => 'bail|required|email|unique:restaurants',
            'password' => 'bail|required|string',
            'phones' => 'bail|required|array',
            'logo' => 'bail|required|file',
            'bank' => 'bail|required|string',
            'agency' => 'bail|required|string',
            'agency_verification_code' => 'bail|required|string',
            'account' => 'bail|required|string',
            'account_verification_code' => 'bail|required|string',
        ];
    }
}
