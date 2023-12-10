<?php

namespace App\Http\Requests;

class RestaurantOccurrenceRequest extends ApiRequest
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
            'reason'   => 'bail|required|string'
        ];
    }

    public function messages()
    {
        return [
            'reason.required' => 'Reason must be Enter',
            'reason.string'   => 'Reason must be String',
        ];
    }
}
