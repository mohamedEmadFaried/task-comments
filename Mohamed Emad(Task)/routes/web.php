<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'App\Http\Controllers\System', 'middleware' => ['XSS']], function () {
  Route::get('/', ['as' => 'admin', 'uses' => 'AuthController@loginForm']);
  Route::get('admin/login', ['as' => 'admin.login-form', 'uses' => 'AuthController@loginForm']);
  Route::post('admin/login', ['as' => 'admin.login', 'uses' => 'AuthController@login']);
  Route::get('admin/logout', ['as' => 'admin.logout', 'uses' => 'AuthController@logout']);

});

Route::group(['prefix' => 'admin', 'middleware' => ['isadmin','XSS'], 'namespace' => 'App\Http\Controllers\System'], function () {
  Route::resource('user', 'UserController', ['as' => 'admin']);
  Route::resource('permission-group', 'PermissionGroupController', ['as' => 'admin']);
  Route::resource('admins', 'AdminController', ['as' => 'admin']);
  Route::resource('article', 'ArticleController', ['as' => 'admin']);
  Route::resource('comment', 'CommentController', ['as' => 'admin']);
  Route::post('admins/approved/{admin}', ['as' => 'admin.admins.approved', 'uses' => 'AdminController@approvedStatus']);
});
