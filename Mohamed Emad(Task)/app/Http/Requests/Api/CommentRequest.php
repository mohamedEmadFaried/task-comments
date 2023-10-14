<?php

namespace App\Http\Requests\Api;

use App\Traits\ValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    use ValidationRequest;

    public function rules()
    {
        $rules = [
            'body' => 'required',
            'article_id' => 'required|exists:articles,id',
        ];
     
        return $rules;
    }
}
