<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankDetailRequest extends ApiRequest
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
            'bank' => 'required|max:255',
            'account' => 'required|max:255',
            'agency' => 'required|max:255',
            'digit' => 'required|integer',
        ];
    }
}
