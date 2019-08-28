<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeekDay;
use App\Models\Exercise;
use App\Models\Routine;
use App\Transformers\ExerciseTransformer;
use Auth;

class WeekDayExerciseController extends Controller
{
    public function show(WeekDay $weekday) {

        $userId = Auth::guard('api')->id();

        $exercises = Exercise::whereHas('routines', function ($query) use ($weekday, $userId) {
            $query->where('user_id', $userId)->where('week_day_id', $weekday->id);
        })->get();

        return fractal()
            ->collection($exercises)
            ->parseIncludes(['user'])
            ->transformWith(new ExerciseTransformer)
            ->toArray();
    }
}
