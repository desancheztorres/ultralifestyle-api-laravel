<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\ExercisePlan;
use App\Transformers\PlanTransformer;
use App\Http\Requests\Plan\{StorePlanRequest, UpdatePlanRequest};
use App\Library\Plan as myPlan;

class PlanController extends Controller
{
    public function index() {
        $plans = Plan::latestFirst()->get();

        return fractal()
            ->collection($plans)
            ->transformWith(new PlanTransformer)
            ->toArray();
    }

    public function show(Plan $plan) {
        return fractal()
            ->item($plan)
            ->transformWith(new PlanTransformer)
            ->toArray();
    }

    public function store(StorePlanRequest $request) {
        //  We create a new Plan
        $plan = new Plan;

        // We get all the data from the request
        $plan->name = $request->name;
        $plan->slug = str_slug($request->name);
        $plan->image = $request->image;
        $plan->description = $request->description;
        $plan->goal = $request->goal;
        $plan->days_week = $request->days_week;
        $plan->avg_time = $request->avg_time;

        $myPlan = new myPlan($request->exercises, $request->recipes);

        $plan->save(); // we save the object

        $myPlan->deleteRecords('exercise_plan', $plan->id, $request->week_day_id);
        $myPlan->deleteRecords('plan_recipe', $plan->id, $request->week_day_id);

        $plan->exercises()->attach($myPlan->getExercisesMapped());
        $plan->recipes()->attach($myPlan->getRecipesMapped());

        return fractal()
            ->item($plan)
            ->transformWith(new PlanTransformer)
            ->toArray();
    }

    public function update(UpdatePlanRequest $request, Plan $plan) {

        $plan->name = $request->get('name', $plan->name);
        $plan->description = $request->get('description', $plan->description);
        $plan->image = $request->get('image', $plan->image);
        $plan->goal = $request->get('goal', $plan->goal);
        $plan->days_week = $request->get('days_week', $plan->days_week);
        $plan->avg_time = $request->get('avg_time', $plan->avg_time);

        $myPlan = new myPlan($request->exercises, $request->recipes);

        $plan->save();

        $myPlan->deleteRecords('exercise_plan', $plan->id, $request->week_day_id);
        $myPlan->deleteRecords('plan_recipe', $plan->id, $request->week_day_id);

        $plan->exercises()->attach($myPlan->getExercisesMapped());
        $plan->recipes()->attach($myPlan->getRecipesMapped());

        return fractal()
            ->item($plan)
            ->transformWith(new PlanTransformer)
            ->toArray();
    }

    public function destroy(Plan $plan) {
        $plan->delete();

        return response(null, 204);
    }
}
