<?php

use App\User;
use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/register', 'RegisterController@register');
Route::get('/test', 'RoutineController@test')->middleware('auth:api');

Route::group(['prefix' => 'users'], function() {
    Route::get('/', 'UserController@index')->middleware('auth:api');
    Route::get('/{user}', 'UserController@show')->middleware('auth:api');
    Route::patch('/{user}', 'UserController@update')->middleware('auth:api');
    Route::delete('/{user}', 'UserController@destroy')->middleware('auth:api');
});

Route::group(['prefix' => 'profile'], function () {
    Route::get('/', 'ProfileController@show')->middleware('auth:api');
    Route::post('/', 'ProfileController@store')->middleware('auth:api');
    Route::patch('/{profile}', 'ProfileController@update')->middleware('auth:api');
    Route::delete('/{profile}', 'ProfileController@destroy')->middleware('auth:api');
});

Route::group(['prefix' => 'blogs'], function() {
    Route::get('/', 'BlogController@index')->middleware('auth:api');
    Route::get('/{blog}', 'BlogController@show')->middleware('auth:api');
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
    Route::get('/', 'RoutineController@index')->middleware('auth:api');
    Route::get('/{routine}', 'RoutineController@show')->middleware('auth:api');
    Route::post('/', 'RoutineController@store')->middleware('auth:api');
    Route::patch('/{routine}', 'RoutineController@update')->middleware('auth:api');
    Route::delete('/{routine}', 'RoutineController@destroy')->middleware('auth:api');
});

Route::group(['prefix' => 'body-parts'], function() {
    Route::get('/', 'BodyPartController@index')->middleware('auth:api');
    Route::get('/{bodyPart}', 'BodyPartController@show')->middleware('auth:api');
    Route::post('/', 'BodyPartController@store')->middleware('auth:api');
    Route::patch('/{bodyPart}', 'BodyPartController@update')->middleware('auth:api');
    Route::delete('/{bodyPart}', 'BodyPartController@destroy')->middleware('auth:api');
});

Route::group(['prefix' => 'exercises'], function() {
    Route::get('/', 'ExerciseController@index')->middleware('auth:api');
    Route::get('/{exercise}', 'ExerciseController@show')->middleware('auth:api');
    Route::post('/', 'ExerciseController@store')->middleware('auth:api');
    Route::patch('/{exercise}', 'ExerciseController@update')->middleware('auth:api');
    Route::delete('/{exercise}', 'ExerciseController@destroy')->middleware('auth:api');
});

Route::group(['prefix' => 'weekdays'], function() {
    Route::get('/', 'WeekDaysController@index')->middleware('auth:api');
    Route::get('/{weekDay}', 'WeekDaysController@show')->middleware('auth:api');
    Route::post('/', 'WeekDaysController@store')->middleware('auth:api');
    Route::patch('/{weekDay}', 'WeekDaysController@update')->middleware('auth:api');
    Route::delete('/{weekDay}', 'WeekDaysController@destroy')->middleware('auth:api');

    Route::group(['prefix' => '/{weekday}/exercises'], function () {
        Route::get('/', 'WeekDayExerciseController@show')->middleware('auth:api');
    });
});