<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Routine;
use App\Models\Exercise;
use App\Transformers\RoutineTransformer;
use App\Models\Profile;
use App\Models\Recipe;
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
            ->parseIncludes(['user', 'exercises'])
            ->transformWith(new RoutineTransformer)
            ->toJson();
    }

    public function store(StoreRoutineRequest $request, Routine $routine) {

        $routine = new Routine;

        $this->authorize('create', $routine);

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
        $this->authorize('update', $routine);
        $userId = Auth::guard('api')->id();
        $calories = 0;
        
        $routine->save();


        if($request->has('exercises')) {
            
            DB::table('exercise_routine')
                ->where('routine_id','=',$routine->id)
                ->where('week_day_id','=',$request->week_day_id)
                ->delete();

            foreach ($request->exercises as $exercise) {
                DB::table('exercise_routine')->insert(
                    ["routine_id" => $routine->id, "exercise_id" => $exercise['exercise_id'], "week_day_id" => $exercise['week_day_id']]
                );
            }
        }

        if($request->has('recipes')) {

            DB::table('recipe_routine')
                ->where('routine_id','=',$routine->id)
                ->where('week_day_id','=',$request->week_day_id)
                ->delete();

            foreach ($request->recipes as $recipe) {

                $recipeCalorie = Recipe::where('id', $recipe["recipe_id"])->first();

                if($recipeCalorie != null) {
                    $calories += $recipeCalorie->calories;
                }


                DB::table('recipe_routine')->insert(
                    ["routine_id" => $routine->id, "recipe_id" => $recipe['recipe_id'], "week_day_id" => $recipe['week_day_id']]
                );
            }
        }

        if($userId != null) {

            Profile::where('user_id', $userId )->update([
                'calories_used' => $calories
            ]);
        }

        return fractal()
            ->item($routine)
            ->parseIncludes(['user', 'exercises'])
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
