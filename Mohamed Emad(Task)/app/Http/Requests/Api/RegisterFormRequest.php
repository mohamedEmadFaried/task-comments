<?php

namespace App\Http\Requests\Api;

use App\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
{
    use ValidationRequest;

    public function rules()
    {
        $rules = [
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required|min:8',
            'username'     => 'required',
        ];

        return $rules;
    }
}
