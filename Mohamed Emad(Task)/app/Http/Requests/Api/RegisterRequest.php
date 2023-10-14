<?php

namespace App\Http\Requests\Api;

use App\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    use ValidationRequest;


    public function rules()
    {
        $rules = [
            'email'    => 'required|unique:users',
            'phone'    => 'required|unique:users',
            'password' => 'required|min:8',
            'username'     => 'required',
        ];
        if (is_numeric(request()->email)) {
            $rules['email'] = 'required|numeric';
        }
        if (filter_var(request()->email, FILTER_VALIDATE_EMAIL)) {
            $rules['email'] = 'required';
        }
        return $rules;
    }
}
