<?php

namespace App\Traits;

trait ApiResponse
{
    public static function apiResponse(
        $code,
        $message,
        $body = null,
        $error = [],
        $strings = null,
        $info = 'from response action'
    ): \Illuminate\Http\JsonResponse {

        return response()->json([
            'code'    => $code,
            'status'  => $code === 200,
            'message' => $message,
            'body'    => $body,
            'error'    => $error,
            'strings' => $strings,
            'info'    => $info,
        ], $code);
    }
}
