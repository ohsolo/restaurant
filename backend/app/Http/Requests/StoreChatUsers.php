<?php

namespace App\Http\Requests;

class StoreChatUsers extends ApiRequest
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
            'rider_id' => 'bail|required|string|exists:riders,rider_id',
            'order_id' => 'bail|required|string|exists:orders,order_id'
        ];
    }
}
