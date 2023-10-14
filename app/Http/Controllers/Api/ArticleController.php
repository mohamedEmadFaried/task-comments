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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    use ApiResponse;


    public function getArticle()
    {
        $article = Article::all();
        $this->message = __('Articles retrieved successfully');
        $this->body['Articles'] = ArticleResource::collection($article);

        return self::apiResponse(200, $this->message, $this->body);
    }
    public function store(Request $request)
    {
        // Create a validator with the validation rules
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return a custom error response with status code 422 (Unprocessable Entity)
            return self::apiResponse(422, $validator->errors());
        }
        $validator = $validator->validated(); // Get the validated data

        // Validation passed, continue processing
        $validator['user_id'] = auth('api')->user()->id;
        $validator['type_user'] = 'user';

        $article = Article::create($validator);
        $this->message = __('Article add successfully');
        $this->body['Article'] = ArticleResource::make($article);

        return self::apiResponse(200, $this->message, $this->body);
    }
    public function update(Request $request, $id)
    {
        // Create a validator with the validation rules
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return a custom error response with status code 422 (Unprocessable Entity)
            return self::apiResponse(422, $validator->errors());
        }
        $validator = $validator->validated(); // Get the validated data
        $findAArticle = Article::find($id);
        if ($findAArticle) {
            // Validation passed, continue processing
            $validator['user_id'] = auth('api')->user()->id;
            $validator['type_user'] = 'user';
            $findAArticle->update($validator);
            $this->message = __('Article update successfully');
            $this->body['Article'] = ArticleResource::make($findAArticle);

            return self::apiResponse(200, $this->message, $this->body);
        } else {
            return self::apiResponse(422, 'not true id');
        }
    }
    public function destory(Request $request, $id)
    {

        $findAArticle = Article::find($id);
        if ($findAArticle) {
            // Validation passed, continue processing
            $findAArticle->delete();
            $this->message = __('Article Delete successfully');

            return self::apiResponse(200, $this->message);
        } else {
            return self::apiResponse(422, 'not true id');
        }
    }
}
