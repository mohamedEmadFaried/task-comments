<?php

namespace App\Http\Controllers\Api;

use Mail;
use Carbon\Carbon;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;

use App\Http\Controllers\Api\Helpers\UserResource;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterFormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponse;


    public function login(LoginRequest $request)
    {

        // Create a validator with the validation rules
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return a custom error response with status code 422 (Unprocessable Entity)
            return self::apiResponse(422, $validator->errors());
        }
        $validator = $validator->validated(); // Get the validated data

        if (!$token = auth()->guard('api')->attempt($validator)) {
            $this->message = __('log_in_error');

            return self::apiResponse(401, $this->message);
        }

        if (auth()->guard('api')->attempt(['email' => $request->email, 'password' => $request->password])) {


            $user = auth('api')->user();
            if ($user->in_block != Null) {
                auth('api')->logout();
                $this->message = __('blocked');

                return self::apiResponse(401, $this->message);
            }
        }


        $user = auth('api')->user();

        return $this->createNewToken($token);
    }

    public function register(RegisterFormRequest $request)
    {
        // Create a validator with the validation rules
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|between:2,100|unique:users',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return a custom error response with status code 422 (Unprocessable Entity)
            return self::apiResponse(422, $validator->errors());
        }
        $validator = $validator->validated(); // Get the validated data

        $validator = $request->validated();
        $validator['password'] = Hash::make($validator['password']);
        $user = User::create($validator);
        // dd($use);
        $this->message = __('Register successfully');
        $this->body['user'] = UserResource::make($user);

        return self::apiResponse(200, $this->message, $this->body);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['status' => true, 'message' => trans('app.logout_success'), 'code' => 200], 200);
    }
    protected function createNewToken($token)
    {
        $this->message = __('token_success');

        $this->body['token'] = $token;

        return self::apiResponse(200, $this->message, $this->body);
    }
}
