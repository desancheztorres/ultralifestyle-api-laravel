<?php

use App\User;
use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/register', 'RegisterController@register');

Route::group(['prefix' => 'blogs'], function() {
    Route::get('/', 'BlogController@index');
    Route::post('/', 'BlogController@store')->middleware('auth:api');
});