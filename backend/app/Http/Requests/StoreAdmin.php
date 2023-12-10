<?php

namespace App\Http\Requests;

class StoreAdmin extends ApiRequest
{
    public function authorize()
    {
        if (request()->admin) return true;

        return false;
    }

    public function rules()
    {
        return [
            "name" => 'bail|required|string|unique:admins',
            "email" => 'bail|required|email|unique:admins',
            "password" => 'bail|required|unique:admins',
        ];
    }
}
