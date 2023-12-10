<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRestaurant extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'         => 'bail|nullable|string',
            'social_reason' => 'bail|nullable|string',
            'cnpj'          => 'bail|nullable|string',
            'public_place'  => 'bail|nullable|string',
            'neighbourhood' => 'bail|nullable|string',
            'cep'           => 'bail|nullable|string',
            'phones'        => 'bail|nullable|array',
            'logo'          => 'bail|nullable|file',
        ];
    }
}
