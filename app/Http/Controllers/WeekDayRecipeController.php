<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeekDay;
use App\Models\Recipe;
use App\Models\Routine;
use App\Transformers\RecipeTransformer;
use Auth;

class WeekDayRecipeController extends Controller
{
    public function show(WeekDay $weekday) {

        $userId = Auth::guard('api')->id();

        $recipes = Recipe::whereHas('routines', function ($query) use ($weekday, $userId) {
            $query->where('user_id', $userId)->where('week_day_id', $weekday->id);
        })->get();

        return fractal()
            ->collection($recipes)
            ->parseIncludes(['user'])
            ->transformWith(new RecipeTransformer)
            ->toArray();
    }
}
