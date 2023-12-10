<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CancelOrderRequest extends FormRequest
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
            'order_cancel_question_id' => 
            'bail|required|exists:order_cancel_questions,order_cancel_question_id',
            'order_cancel_question'    => 'bail|required',  
            'order_cancel_comment'     => 'bail|nullable'  
        ];
    }
}
