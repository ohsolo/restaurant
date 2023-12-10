<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RiderRegister extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'bail|required|string',
            'email' => 'bail|required|email|unique:riders',
            'password' => 'bail|required|string',
            'cpf' => 'bail|required',
            'phone' => 'bail|required|string|unique:riders',
            'vehicle_type' => 'bail|required|string',
            'profile_image' => 'bail|required|file',
            'cnh_image' => 'bail|required|file',
            'region_id' => 'bail|required|string',
        ];
    }
}
