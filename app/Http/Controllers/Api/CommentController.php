<?php

namespace App\Http\Controllers\Api;

use Mail;
use Carbon\Carbon;
use App\Models\User;

use Tymon\JWTAuth\Facades\JWTAuth;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Traits\ApiResponse;
use App\Http\Controllers\Api\Helpers\ArticleResource;
use App\Http\Controllers\Api\Helpers\CommentResource;
use App\Http\Requests\Api\CommentArticleRequest;
use App\Http\Requests\Api\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    use ApiResponse;


    public function store(Request $request)
    {
        // Create a validator with the validation rules
        $validator = Validator::make($request->all(), [
            'body' => 'required',
            'article_id' => 'required|exists:articles,id',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return a custom error response with status code 422 (Unprocessable Entity)
            return self::apiResponse(422, $validator->errors());
        }
        $validator = $validator->validated(); // Get the validated data

        // Validation passed, continue processing
        $validator['user_id'] = auth('api')->user()->id;

        $comment = Comment::create($validator);
        $this->message = __('comment add successfully');
        $this->body['Comment'] = CommentResource::make($comment);

        return self::apiResponse(200, $this->message, $this->body);
    }

    public function getComments(Request $request)
    {

        // Create a validator with the validation rules
        $validator = Validator::make($request->all(), [
            'article_id' => 'required|exists:articles,id',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return a custom error response with status code 422 (Unprocessable Entity)
            return self::apiResponse(422, $validator->errors());
        }
        $validator = $validator->validated(); // Get the validated data

        $article = Article::find($validator['article_id']);
        $this->message = __('Articles retrieved successfully');
        $this->body['Articles'] = ArticleResource::make($article);

        return self::apiResponse(200, $this->message, $this->body);
    }
}
