<?php

use Illuminate\Http\Request;

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

Route::post('auth/register', 'JWTAuthController@register');
Route::post('auth/login', 'JWTAuthController@login');

Route::group(['middleware' => 'jwt.auth'], function(){
    Route::get('auth/user', 'JWTAuthController@user');
    Route::get('auth/logout', 'JWTAuthController@logout');
});

Route::middleware('jwt.refresh')->get('users/token/refresh', 'JWTAuthController@refresh');

Route::post('callback/bank', 'BankController@index');
