<?php

namespace App\Http\Requests;

class StoreOrder extends ApiRequest
{
    public function rules()
    {
        return [
            'branch_id'                 => 'bail|required|string|exists:branches,branch_id',
            'address_id'                => 'bail|required|string|exists:addresses,address_id',
            'customer_name'             => 'bail|required',
            'customer_phone'            => 'bail|required',
            'customer_other_info'       => 'bail|required',
            'output_time'               => 'bail|required',
            'order_method'              => 'bail|required|string',
            'payment_method'            => 'bail|required|string',
            'dishes_info'               => 'bail|required|string',
            'observations'              => 'bail|required|string',
            'remarks'                   => 'bail|required|string',
            'compliments'               => 'bail|required|string',
            'comments'                  => 'bail|required|string',
            'response'                  => 'bail|required|string',
            'restaurant_order_amount'   => 'bail|required',
        ];
    }
}