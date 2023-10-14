<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::middleware(['jwt-verfiy'])->group(function () {
    Route::get('/getArticle', [ArticleController::class, 'getArticle']);
    Route::post('/article/store', [ArticleController::class, 'store']);
    Route::post('/article/update/{id}', [ArticleController::class, 'update']);
    Route::post('/article/destory/{id}', [ArticleController::class, 'destory']);
    Route::post('/articles/comment/store', [CommentController::class, 'store']);
    Route::post('/articles/getComments', [CommentController::class, 'getComments']);
});
