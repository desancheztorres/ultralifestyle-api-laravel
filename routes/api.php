<?php

use App\User;
use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/register', 'RegisterController@register');

Route::group(['prefix' => 'blogs'], function() {
    Route::get('/', 'BlogController@index');
    Route::get('/{blog}', 'BlogController@show');
    Route::post('/', 'BlogController@store')->middleware('auth:api');
    Route::patch('/{blog}', 'BlogController@update')->middleware('auth:api');
    Route::delete('/{blog}', 'BlogController@destroy')->middleware('auth:api');

    Route::group(['prefix' => '/{blog}/posts'], function () {
        Route::post('/', 'PostController@store')->middleware('auth:api');
        Route::patch('/{post}', 'PostController@update')->middleware('auth:api');
        Route::delete('/{post}', 'PostController@destroy')->middleware('auth:api');

        Route::group(['prefix' => '/{post}/likes'], function () {
            Route::post('/', 'PostLikeController@store')->middleware('auth:api');
//            Route::delete('/{post}', 'PostLikeController@destroy')->middleware('auth:api');
        });

    });
});

Route::group(['prefix' => 'routines'], function() {
    Route::get('/', 'RoutineController@index');
    Route::get('/{routine}', 'RoutineController@show')->middleware('auth:api');
    Route::post('/', 'RoutineController@store')->middleware('auth:api');
    Route::patch('/{routine}', 'RoutineController@update')->middleware('auth:api');
    Route::delete('/{routine}', 'RoutineController@destroy')->middleware('auth:api');
});