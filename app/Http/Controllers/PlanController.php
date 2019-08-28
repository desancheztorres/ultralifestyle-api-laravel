<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Transformers\PlanTransformer;
use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;

class PlanController extends Controller
{
    public function index() {
        $plans = Plan::latestFirst()->get();

        return fractal()
            ->collection($plans)
            ->parseIncludes(['user', 'exercises'])
            ->transformWith(new PlanTransformer)
            ->toArray();
    }

    public function show(Plan $plan) {
        return fractal()
            ->item($plan)
            ->parseIncludes(['user', 'exercises'])
            ->transformWith(new PlanTransformer)
            ->toArray();
    }

    public function store(StorePlanRequest $request, Plan $plan) {
        $plan = new Plan;

        $plan->name = $request->name;
        $plan->description = $request->description;
        $plan->user()->associate($request->user());

        $exercisesIds = array();


        foreach($request->exercises as $exercise) {
            $arrayTemp = $exercise['exercise_id'];

            array_push($exercisesIds, $arrayTemp);
        }

        $exercisesList = array_combine($exercisesIds, $request->exercises);

        $plan->save();

        $plan->exercises()->sync($exercisesList);

        return fractal()
            ->item($plan)
            ->parseIncludes(['user', 'exercises'])
            ->transformWith(new PlanTransformer)
            ->toArray();
    }

    public function update(UpdatePlanRequest $request, Plan $plan) {
        $this->authorize('update', $plan);
        $plan->name = $request->get('name', $plan->name);
        $plan->description = $request->get('description', $plan->description);

        $exercisesIds = array();


        foreach($request->exercises as $exercise) {
            $arrayTemp = $exercise['exercise_id'];

            array_push($exercisesIds, $arrayTemp);
        }

        $exercisesList = array_combine($exercisesIds, $request->exercises);

        $plan->save();

        $plan->exercises()->sync($exercisesList);

        return fractal()
            ->item($plan)
            ->parseIncludes(['user', 'exercises'])
            ->transformWith(new PlanTransformer)
            ->toArray();
    }

    public function destroy(Plan $plan) {
        $this->authorize('destroy', $plan);

        $plan->delete();

        return response(null, 204);
    }
}
