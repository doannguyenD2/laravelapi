<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login')->name('login');
Route::get('verify/{token}','AuthController@verify');
Route::get('test', function () {
    return 'test';
})->middleware('auth:api','verifiedMail');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
