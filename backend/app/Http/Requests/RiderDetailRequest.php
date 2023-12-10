<?php

namespace App\Http\Requests;

class RiderDetailRequest extends ApiRequest
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
            'name' => 'required|max:255',
            'cpf'  => 'required|max:255',
            'phone'  => 'required|max:255',
        ];
    }
}
