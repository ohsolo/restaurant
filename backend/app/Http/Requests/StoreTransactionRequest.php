<?php

namespace App\Http\Requests;

use App\Models\Transaction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTransactionRequest extends ApiRequest
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
            'orders.*'       => 'required|exists:orders,order_id|unique:order_transactions,order_id',
            'rider_id'       => 'required|exists:riders,rider_id',
            'rest_id'        => 'required|exists:restaurants,rest_id',
            'request_status' => 'nullable|in:quick_withdraw_request'
        ];
    }
}
