<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRestaurantRatingQuestion extends FormRequest
{ 
    public function rules()
    {
        return [
            'text' => 'bail|required|string'
        ];
    }
}
