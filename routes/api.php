<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Routine;
use App\Models\User;


/*
    1. REGISTER
    2. PROFILE
    3. USER
    4. NEWS
    5. PLANS
    6. ROUTINES
    7. BODY-PARTS
    8. EXERCISES
    9. RECIPES
    10. RECIPE-CATEGORIES
    11. WEEKDAYS
    12. PASSWORD
    13. WEIGHTS
    14. TARGETS
    15. GENDERS
    16. ETHNICS
    17. EXPERIENCE LEVEL
    18. WORKOUTS
    19. WORKOUTS HISTORY
    20. AVATARS
*/

/*
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ REGISTER --------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------
*/

Route::post('/register', 'RegisterController@register');

/*
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ PROFILE ---------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------
*/

Route::group(['prefix' => 'profiles'], function () {
    Route::get('/', 'ProfileController@index')->middleware('auth:api');
    Route::get('/show', 'ProfileController@show')->middleware('auth:api');
    Route::get('/active', 'ProfileController@active')->middleware('auth:api');
    Route::post('/', 'ProfileController@store')->middleware('auth:api');
    Route::patch('/user/update/', 'ProfileController@update')->middleware('auth:api');
    Route::delete('/', 'ProfileController@destroy')->middleware('auth:api');
});

/*
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ USERS ------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------
*/

Route::group(['prefix' => 'users'], function () {
    Route::get('/', 'UserController@index')->middleware('auth:api');
    Route::get('/show/{user}', 'UserController@show')->middleware('auth:api');
    Route::get('/info', 'UserController@info')->middleware('auth:api');
    Route::patch('/{user}','UserController@update');
    Route::post('/logout','UserController@logoutApi');
});

/*
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ NEWS -----------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------
*/

Route::group(['prefix' => 'news'], function() {
    Route::get('/', 'NewsController@index')->middleware('auth:api');
    Route::get('/{news}', 'NewsController@show')->middleware('auth:api');
    Route::get('/show/latest', 'NewsController@latest')->middleware('auth:api');
    Route::post('/', 'NewsController@store')->middleware('auth:api');
    Route::patch('/{news}', 'NewsController@update')->middleware('auth:api');
    Route::delete('/{news}', 'NewsController@destroy')->middleware('auth:api');

//    Route::group(['prefix' => '/{blog}/posts'], function () {
//        Route::post('/', 'PostController@store')->middleware('auth:api');
//        Route::patch('/{post}', 'PostController@update')->middleware('auth:api');
//        Route::delete('/{post}', 'PostController@destroy')->middleware('auth:api');
//
//        Route::group(['prefix' => '/{post}/likes'], function () {
//            Route::post('/', 'PostLikeController@store')->middleware('auth:api');
////            Route::delete('/{post}', 'PostLikeController@destroy')->middleware('auth:api');
//        });
//
//    });
});

/*
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ PLANS -----------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------
*/

Route::group(['prefix' => 'plans'], function() {
    Route::get('/', 'PlanController@index')->middleware('auth:api');
    Route::get('/{plan}', 'PlanController@show')->middleware('auth:api');
    Route::post('/', 'PlanController@store')->middleware('auth:api');
    Route::patch('/{plan}', 'PlanController@update')->middleware('auth:api');
    Route::delete('/{plan}', 'PlanController@destroy')->middleware('auth:api');
});

/*
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ ROUTINES --------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------
*/

Route::group(['prefix' => 'routines'], function() {
    Route::get('/', 'RoutineController@index')->middleware('auth:api');
    Route::get('/{routine}', 'RoutineController@show')->middleware('auth:api');
    Route::get('/user/show', 'RoutineController@routine')->middleware('auth:api');
    Route::get('/exercises/show', 'RoutineController@exercises')->middleware('auth:api');
    Route::post('/', 'RoutineController@store')->middleware('auth:api');
    Route::patch('/{routine}', 'RoutineController@update')->middleware('auth:api');
    Route::delete('/{routine}', 'RoutineController@destroy')->middleware('auth:api');
});

/*
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ BODY-PARTS ------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------
*/

Route::group(['prefix' => 'body-parts'], function() {
    Route::get('/', 'BodyPartController@index')->middleware('auth:api');
    Route::get('/{bodyPart}', 'BodyPartController@show')->middleware('auth:api');
    Route::post('/', 'BodyPartController@store')->middleware('auth:api');
    Route::patch('/{bodyPart}', 'BodyPartController@update')->middleware('auth:api');
    Route::delete('/{bodyPart}', 'BodyPartController@destroy')->middleware('auth:api');
});

/*
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ EXERCISES -------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------
*/

Route::group(['prefix' => 'exercises'], function() {
    Route::get('/', 'ExerciseController@index')->middleware('auth:api'); //->middleware('auth:api')
    Route::get('/{exercise}', 'ExerciseController@show')->middleware('auth:api');
    Route::post('/', 'ExerciseController@store')->middleware('auth:api');
    Route::patch('/{exercise}', 'ExerciseController@update')->middleware('auth:api');
    Route::delete('/{exercise}', 'ExerciseController@destroy')->middleware('auth:api');
});

/*
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ RECIPES ---------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------
*/

Route::group(['prefix' => 'recipes'], function() {
    Route::get('/', 'RecipeController@index')->middleware('auth:api');
    Route::get('/{category}/show', 'RecipeController@category')->middleware('auth:api');
    Route::get('/{recipe}', 'RecipeController@show')->middleware('auth:api');
    Route::post('/', 'RecipeController@store')->middleware('auth:api');
    Route::patch('/{recipe}', 'RecipeController@update')->middleware('auth:api');
    Route::delete('/{recipe}', 'RecipeController@destroy')->middleware('auth:api');
});

/*
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ RECIPE-CATEGORIES -----------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------
*/

Route::group(['prefix' => 'recipe-categories'], function() {
    Route::get('/', 'RecipeCategoryController@index')->middleware('auth:api');
    Route::get('/{category}', 'RecipeCategoryController@show')->middleware('auth:api');
    Route::post('/', 'RecipeCategoryController@store')->middleware('auth:api');
    Route::patch('/{recipeCategory}', 'RecipeCategoryController@update')->middleware('auth:api');
    Route::delete('/{recipeCategory}', 'RecipeCategoryController@destroy')->middleware('auth:api');
});

/*
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ WEEKDAYS --------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------
*/

Route::group(['prefix' => 'weekdays'], function() {
    Route::get('/', 'WeekDaysController@index')->middleware('auth:api');
    Route::get('/{weekDay}', 'WeekDaysController@show')->middleware('auth:api');

    Route::group(['prefix' => '/{weekday}/exercises'], function () {
        Route::get('/', 'WeekDayExerciseController@show')->middleware('auth:api');
    });

    Route::group(['prefix' => '/{weekday}/recipes'], function () {
        Route::get('/', 'WeekDayRecipeController@show')->middleware('auth:api');
    });
});

/*
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ PASSWORD --------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'password'
], function () {
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset')->name('reset');
});

/*
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ WEIGHTS --------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------
*/

Route::group(['prefix' => 'weights'], function() {
    Route::get('/', 'WeightController@index')->middleware('auth:api');
    Route::get('/{height}', 'WeightController@show')->middleware('auth:api');
    Route::post('/', 'WeightController@store')->middleware('auth:api');
    Route::patch('/{height}', 'WeightController@update')->middleware('auth:api');
    Route::delete('/{height}', 'WeightController@destroy')->middleware('auth:api');
});

/*
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ TARGETS --------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------
*/

Route::group(['prefix' => 'targets'], function() {
    Route::get('/', 'TargetController@index')->middleware('auth:api');
    Route::get('/{target}', 'TargetController@show')->middleware('auth:api');
    Route::post('/', 'TargetController@store')->middleware('auth:api');
    Route::patch('/{target}', 'TargetController@update')->middleware('auth:api');
    Route::delete('/{target}', 'TargetController@destroy')->middleware('auth:api');
});

/*
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ GENDERS --------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------
*/

Route::group(['prefix' => 'genders'], function() {
    Route::get('/', 'GenderController@index')->middleware('auth:api');
    Route::get('/{gender}', 'GenderController@show')->middleware('auth:api');
    Route::post('/', 'GenderController@store')->middleware('auth:api');
    Route::patch('/{gender}', 'GenderController@update')->middleware('auth:api');
    Route::delete('/{gender}', 'GenderController@destroy')->middleware('auth:api');
});

/*
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ ETHNICS --------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------
*/

Route::group(['prefix' => 'ethnics'], function() {
    Route::get('/', 'EthnicController@index')->middleware('auth:api');
    Route::get('/{ethnic}', 'EthnicController@show')->middleware('auth:api');
    Route::post('/', 'EthnicController@store')->middleware('auth:api');
    Route::patch('/{ethnic}', 'EthnicController@update')->middleware('auth:api');
    Route::delete('/{ethnic}', 'EthnicController@destroy')->middleware('auth:api');
});

/*
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ EXPERIENCE LEVEL ------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------
*/

Route::group(['prefix' => 'experience-levels'], function() {
    Route::get('/', 'ExperienceLevelController@index')->middleware('auth:api');
    Route::get('/{level}', 'ExperienceLevelController@show')->middleware('auth:api');
    Route::post('/', 'ExperienceLevelController@store')->middleware('auth:api');
    Route::patch('/{level}', 'ExperienceLevelController@update')->middleware('auth:api');
    Route::delete('/{level}', 'ExperienceLevelController@destroy')->middleware('auth:api');
});

/*
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ WORKOUTS --------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------
*/

Route::group(['prefix' => 'workouts'], function() {
    Route::get('/', 'WorkoutController@index')->middleware('auth:api');
    Route::get('/{id}', 'WorkoutController@show')->middleware('auth:api');
    Route::get('/day/{day}', 'WorkoutController@showDaily')->middleware('auth:api');
    Route::get('/start/{day}', 'WorkoutController@start')->middleware('auth:api');
    Route::patch('/update/{day}/{exercise}', 'WorkoutController@update')->middleware('auth:api');
});

/*
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ WORKOUTS HISTORY ------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------
*/

Route::group(['prefix' => 'workouts-history'], function() {
    Route::get('/', 'WorkoutHistoryController@index')->middleware('auth:api');
    Route::get('/{date}', 'WorkoutHistoryController@showByDate')->middleware('auth:api');
    Route::post('/', 'WorkoutHistoryController@store')->middleware('auth:api');
});

/*
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ AVATARS ---------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------
*/

Route::group(['prefix' => 'avatars'], function() {
    Route::post('/', 'AvatarController@store')->middleware('auth:api');
    Route::post('/update', 'AvatarController@update')->middleware('auth:api');
});
