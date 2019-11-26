<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\RoutineTransformer;
use App\Models\{Profile, Plan, Recipe, Exercise, Routine};
use Auth;
use App\Http\Requests\Routine\{StoreRoutineRequest, UpdateRoutineRequest};
use App\Library\Routine as MyRoutine;

class RoutineController extends Controller
{
    public function index() {
        $routines = Routine::latestFirst()->get();

        return fractal()
            ->collection($routines)
            ->parseIncludes(['exercises'])
            ->transformWith(new RoutineTransformer)
            ->toArray();
    }

    public function show(Routine $routine) {

        $this->authorize('show', $routine);

        return fractal()
            ->item($routine)
            ->parseIncludes(['user', 'exercises'])
            ->transformWith(new RoutineTransformer)
            ->toJson();
    }

    public function store(StoreRoutineRequest $request) {

        $routine = new Routine;

        $this->authorize('create', $routine);

        $plan = Plan::where('id', $request->plan_id)->firstOrFail();

        $routine->name = $plan->name;
        $routine->image = $plan->image;
        $routine->description = $plan->description;
        $routine->goal = $plan->goal;
        $routine->days_week = $plan->days_week;
        $routine->avg_time = $plan->avg_time;
        $routine->user()->associate($request->user());

        $myRoutine = new MyRoutine($request->exercises, $request->recipes);

        $routine->save();

        if($request->has('exercises')) {
            $myRoutine->deleteRecords('exercise_routine', $routine->id, $request->week_day_id);
            $routine->exercises()->attach($myRoutine->getExercisesMapped());
        }

        if($request->has('recipes')) {
            $myRoutine->deleteRecords('recipe_routine', $routine->id, $request->week_day_id);
            $routine->recipes()->attach($myRoutine->getRecipesMapped());
        }

        return fractal()
            ->item($routine)
            ->parseIncludes(['exercises'])
            ->transformWith(new RoutineTransformer)
            ->toArray();
    }

    public function update(UpdateRoutineRequest $request, Routine $routine) {
        $this->authorize('update', $routine);
//        $userId = Auth::guard('api')->id();

        $routine->name = $request->get('name', $routine->name);
        $routine->image = $request->get('image', $routine->image);
        $routine->description = $request->get('description', $routine->description);
        $routine->goal = $request->get('goal', $routine->goal);
        $routine->days_week = $request->get('days_week', $routine->days_week);
        $routine->avg_time = $request->get('avg_time', $routine->avg_time);
        $routine->user()->associate($request->user());

        $myRoutine = new MyRoutine($request->exercises, $request->recipes);

        $routine->save();

        if($request->has('exercises')) {
            $myRoutine->deleteRecords('exercise_routine', $routine->id, $request->week_day_id);
            $routine->exercises()->attach($myRoutine->getExercisesMapped());
        }

        if ($request->has('recipes')) {
            $myRoutine->deleteRecords('recipe_routine', $routine->id, $request->week_day_id);
            $routine->recipes()->attach($myRoutine->getRecipesMapped());
        }

        return fractal()
            ->item($routine)
            ->parseIncludes(['exercises'])
            ->transformWith(new RoutineTransformer)
            ->toArray();
    }

    public function destroy(Routine $routine) {
        $this->authorize('destroy', $routine);

        $routine->delete();

        return response(null, 204);
    }

    public function routine() {
        $userId = Auth::guard('api')->id();
        $routine = Routine::where('user_id', $userId)->first();

        return fractal()
            ->item($routine)
            ->parseIncludes(['exercises'])
            ->transformWith(new RoutineTransformer)
            ->toArray();
    }

    public function exercises() {
        $userId = Auth::guard('api')->id();

        $routine = Routine::where('user_id', $userId)->first();

        $exercises = [];

        foreach ($routine->exercises as $exercise) {
            array_push($exercises, $exercise);
        }

        return response()->json([
            'data' => [
                $exercises
            ]
        ], 200);
    }

}
