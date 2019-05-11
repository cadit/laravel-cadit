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
Route::post('auth/phone', 'VerificationController@send');

Route::group(['middleware' => 'jwt.auth'], function(){
    Route::get('auth/user', 'JWTAuthController@user');
    Route::get('auth/logout', 'JWTAuthController@logout');

    Route::post('users/card', 'CardController@store');

    Route::post('users/bank', 'BankController@store');

    Route::get('users/goals', 'GoalController@show');
    Route::post('users/goals', 'GoalController@store');

    Route::get('users/deposits', 'DepositController@index');
});

Route::get('users/{user_id}/deposits', 'DepositController@pdfRenderFromDepositList'); // pdf render

Route::middleware('jwt.refresh')->get('auth/token/refresh', 'JWTAuthController@refresh');

Route::post('callback/bank', 'BankController@callback'); // test callback function

