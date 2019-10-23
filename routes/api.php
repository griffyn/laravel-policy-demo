<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api'], 'prefix' => 'v1'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::match(['get', 'post'], 'logout', ['uses' => 'Api\AuthController@logout']);
        Route::get('me', 'Api\AuthController@me');
    });
    Route::group(['prefix' => 'user'], function () {
        Route::post('register', 'Api\UserController@register');
        Route::put('{uuid}/password', 'Api\UserController@password');
    });
});

Route::group(['middleware' => 'api', 'prefix' => 'v1'], function () {
    Route::post('auth/login', 'Api\AuthController@login');
});
