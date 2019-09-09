<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Routine;
use App\Models\Exercise;
use App\Transformers\RoutineTransformer;
use App\Http\Requests\StoreRoutineRequest;
use App\Http\Requests\UpdateRoutineRequest;
use App\Models\User;
use Auth;
use DB;

class RoutineController extends Controller
{
    public function index() {
        $routines = Routine::latestFirst()->get();

        return fractal()
            ->collection($routines)
            ->parseIncludes(['user', 'exercises'])
            ->transformWith(new RoutineTransformer)
            ->toArray();
    }

    public function show(Routine $routine) {

        $this->authorize('show', $routine);

        return fractal()
            ->item($routine)
            ->transformWith(new RoutineTransformer)
            ->toJson();
    }

    public function store(StoreRoutineRequest $request, Routine $routine) {

        $routine = new Routine;

        $this->authorize('create', $routine);

        $routine->name = $request->name;
        $routine->description = $request->description;
        $routine->user()->associate($request->user());

        $exercisesIds = array();


        foreach($request->exercises as $exercise) {
            $arrayTemp = $exercise['exercise_id'];

            array_push($exercisesIds, $arrayTemp);
        }

        $exercisesList = array_combine($exercisesIds, $request->exercises);

        dd($request->exercises);

        $routine->save();

        $routine->exercises()->sync($exercisesList);
//        $routine->recipes()->sync($request->recipes);

        return fractal()
            ->item($routine)
            ->parseIncludes(['user', 'exercises'])
            ->transformWith(new RoutineTransformer)
            ->toArray();
    }

    public function update(UpdateRoutineRequest $request, Routine $routine) {

//        $routine = Routine::where('user_id', Auth::guard('api')->id())->get();

        $this->authorize('update', $routine);
        $routine->name = $request->get('name', $routine->name);
        $routine->description = $request->get('description', $routine->description);

        $exercisesIds = array();


        foreach($request->exercises as $exercise) {
            $arrayTemp = $exercise['exercise_id'];

            array_push($exercisesIds, $arrayTemp);
        }

        $exercisesList = array_combine($exercisesIds, $request->exercises);

        $routine->save();

        $userId = Auth::guard('api')->id();

        DB::table('exercise_routine')
        ->where('routine_id','=',$routine->id)
        ->where('week_day_id','=',$request->week_day_id)
        ->delete();




        foreach ($request->exercises as $exercise) {
            DB::table('exercise_routine')->insert(
                ["routine_id" => $routine->id, "exercise_id" => $exercise['exercise_id'], "week_day_id" => $exercise['week_day_id']]
            );
        }


        $recipeRoutine = DB::table('recipe_routine')
            ->where('routine_id', $routine->id)
            ->select('id')->get()->toArray();

        foreach($recipeRoutine as $item) {
            echo $item->id;
        }


//        return fractal()
//            ->item($routine)
//            ->parseIncludes(['user', 'exercises'])
//            ->transformWith(new RoutineTransformer)
//            ->toArray();
    }

    public function destroy(Routine $routine) {
        $this->authorize('destroy', $routine);

        $routine->delete();

        return response(null, 204);
    }

    public function routine() {

        $routine = Routine::where('user_id', Auth::guard('api')->id())->get();

        return fractal()
            ->collection($routine)
            ->transformWith(new RoutineTransformer)
            ->toArray();
    }
}
