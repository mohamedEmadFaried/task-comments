<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleFormRequest extends FormRequest
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
        switch ($this->method()) {
            case 'GET': {
                    return [];
                }
            case 'DELETE': {
                    return [];
                }
            case 'POST': {

                    $validation = [
                        'title' => 'required|string',
                        'content' => 'required|string',
                    ];

                    return $validation;
                }
            case 'PUT':
            case 'PATCH': {
                    $validation = [
                        'title' => 'required|string',
                        'content' => 'required|string',
                    ];

                    return $validation;
                }
            default:
                break;
        }
    }
}
