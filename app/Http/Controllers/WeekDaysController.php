<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeekDay;
use App\Transformers\WeekDayTransformer;
use App\Http\Requests\UpdateWeekDayRequest;
use App\Http\Requests\StoreWeekDayRequest;

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

    public function store(UpdateWeekDayRequest $request) {
        $weekday = new WeekDay;

        $weekday->name = $request->name;
        $weekday->save();

        return fractal()
            ->item($weekday)
            ->transformWith(new WeekDayTransformer)
            ->toArray();
    }

    public function update(UpdateWeekDayRequest $request, WeekDay $weekDay) {
        $weekDay->name = $request->get('name', $weekDay->name);

        $weekDay->save();

        return fractal()
            ->item($weekDay)
            ->transformWith(new WeekDayTransformer)
            ->toArray();
    }

    public function destroy(WeekDay $weekDay) {
        $weekDay->delete();

        return response(null, 204);
    }
}
