<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeekDay;
use App\Transformers\WeekDayTransformer;

class WeekDaysController extends Controller
{
    public function index() {
        $weekdays = WeekDay::get();

        return fractal()
            ->collection($weekdays)
            ->transformWith(new WeekDayTransformer)
            ->toArray();
    }

    public function show(WeekDay $weekDay) {
        return fractal()
            ->item($weekDay)
            ->transformWith(new WeekDayTransformer)
            ->toArray();
    }
    
}
