<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeekDay;
use App\Models\Exercise;

class WeekDayExerciseController extends Controller
{
    public function show(WeekDay $weekday, Exercise $exercises) {
        $exercises = Exercise::routines()->wherePivot('week_day_id', $weekday)->get();

        dd($exercises);
    }
}
