<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class FilterOrderRequest extends ApiRequest
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
            'order_number' =>  'bail|nullable|exists:orders,order_number',
            'by_period'    => 'bail|nullable',
            // #TODO: DATE FORMAT
            'start_date'   => 'bail|nullable',
            'end_date'     => 'bail|nullable',
            'deliverer'    => 'bail|nullable|exists:riders,rider_id',
            'region'       => 'bail|nullable|exists:addresses,address_id',
            'status'       => [
                'nullable',
                Rule::in([
                    Order::STATUS_DELIVERED,
                    Order::STATUS_PENDING,
                    Order::STATUS_REJECTED,
                    Order::STATUS_RESEARCH,
                ])]
        ];
    }
    public function messages()
    {
        return [
            'order_number.exists' => 'Order not found in our database',
            'deliverer.exists'    => 'Deliverer not found in our database',
            'region.exists'       => 'Region not found in our database',
            'status.in'           => 'Incorrect Value for status',  
        ];
    }
}
