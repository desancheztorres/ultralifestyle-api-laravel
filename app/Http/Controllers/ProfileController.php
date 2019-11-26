<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;
use App\Transformers\ProfileTransformer;#
use App\Http\Requests\Profile\{StoreProfileRequest, UpdateProfileRequest};
use App\Policies\ProfilePolicy;
use App\Models\{User, Profile, Routine, Plan, Exercise, Target, Gender};
use Carbon\Carbon;
use App\Library\{Nutrition as MyNutrition, BodyMetric};

class ProfileController extends Controller
{
    public function index() {
        $profiles = Profile::get();

        return fractal()
            ->collection($profiles)
            ->transformWith(new ProfileTransformer)
            ->toArray();
    }

    public function show() {

        $userId = Auth::guard('api')->id();

        $profile = Profile::where('user_id', $userId)->firstOrFail();

        return fractal()
            ->item($profile)
            ->transformWith(new ProfileTransformer)
            ->toArray();
    }

    public function store(StoreProfileRequest $request) {
        $profile = new Profile;

        $this->authorize('profile', $profile);

        $height = $request->get('height');
        $weight = $request->get('weight');
        $gender = $request->get('gender');
        $age = Carbon::parse($request->dob)->age;

        $nutrition = new MyNutrition();
        $bodyMetric = new BodyMetric($gender, $age, $height, $weight);

        $bmi = $bodyMetric->getBmi();
        $bmr = $bodyMetric->getBmr();

        $target = Target::where('id', $request->target_id)->first();

        switch($target->type) {
            case "lw":
                $nutrition->setNutritionValues(.50, .30, .20, -300, $bmr);
                break;
            case "bm":
                $nutrition->setNutritionValues(.40, .20, .40, 300, $bmr);
                break;
            case "m":
                $nutrition->setNutritionValues(.40, .30, .20, 0, $bmr);
                break;
            default :
                $nutrition->setNutritionValues(.20, .20, .20, 0, $bmr);
        }

        $profile->dob = $request->dob;
        $profile->height = $height;
        $profile->weight = $weight;
        $profile->gender = $request->gender;
        $profile->ethnic_id = $request->ethnic_id;
        $profile->target_id = $request->target_id;
        $profile->user()->associate($request->user());
        $profile->bmi = (float) number_format($bmi, 2, '.', ',');
        $profile->bmr = $bmr;
        $profile->calories = $nutrition->getCalories();
        $profile->calories_used = 0;
        $profile->protein = $nutrition->getProtein();
        $profile->fat = $nutrition->getFat();
        $profile->carb = $nutrition->getCarb();

        $profile->save();

        return fractal()
            ->item($profile)
            ->transformWith(new ProfileTransformer)
            ->toArray();
    }

    public function update(UpdateProfileRequest $request) {

        $userId = Auth::guard('api')->id();

        $profile = Profile::where('user_id', $userId)->first();

        $this->authorize('update', $profile);

        $height = $request->get('height');
        $weight = $request->get('weight');
        $gender = $request->get('gender');
        $dob = $request->get('dob', $profile->dob);
        $age = Carbon::parse($dob)->age;

        $nutrition = new MyNutrition();
        $bodyMetric = new BodyMetric($gender, $age, $height, $weight);

        $bmi = $bodyMetric->getBmi();
        $bmr = $bodyMetric->getBmr();


        $target = Target::where('id', $request->target_id)->first();

        switch($target->type) {
            case "lw":
                $nutrition->setNutritionValues(.50, .30, .20, -300, $bmr);
                break;
            case "bm":
                $nutrition->setNutritionValues(.40, .20, .40, 300, $bmr);
                break;
            case "m":
                $nutrition->setNutritionValues(.40, .30, .20, 0, $bmr);
                break;
            default :
                $nutrition->setNutritionValues(.20, .20, .20, 0, $bmr);
        }

        $profile->dob = $dob;
        $profile->height = $request->get('height', $profile->height);
        $profile->weight = $request->get('weight', $profile->weight);
        $profile->gender = $gender;
        $profile->ethnic_id = $request->get('ethnic_id', $profile->ethnic->id);
        $profile->target_id = $target->id;
        $profile->bmi = $bmi;
        $profile->bmr = $bmr;
        $profile->calories = $nutrition->getCalories();
        $profile->protein = $nutrition->getProtein();
        $profile->fat = $nutrition->getFat();
        $profile->carb = $nutrition->getCarb();
        $profile->save();

        return fractal()
            ->item($profile)
            ->transformWith(new ProfileTransformer)
            ->toArray();
    }

    public function destroy() {

        $userId = Auth::guard('api')->id();

        $profile = Profile::where('user_id', $userId)->first();

        $this->authorize('destroy', $profile);

        $profile->delete();

        return response(null, 204);
    }

    public function createUserRoutine($target) {
        $user = Auth::guard('api')->user();

        $routine = new Routine();
        $routine->user()->associate($user->id);

        $plan = Plan::where('name', $target)->first();

        $exercisesIds = array();
        $exercisesAttributes = array();
        $plansIds = array();
        $plansAttributes = array();

        // We create the routine with the exercises selected in Plan
        $exercisePlans = DB::table('exercise_plan')
            ->select('exercise_id', 'reps', 'sets', 'week_day_id')
            ->where('plan_id', $plan->id)->get()->toArray();

        foreach ($exercisePlans as $exercise) {
            array_push($exercisesIds,$exercise->exercise_id);
            array_push($exercisesAttributes, (array) $exercise);
        }

        // We create the routine with the recipes selected in Plan
        $recipesPlans = DB::table('recipe_plan')
            ->select('recipe_id', 'week_day_id')
            ->where('plan_id', $plan->id)->get()->toArray();

        foreach ($recipesPlans as $recipe) {
            array_push($plansIds, $recipe->recipe_id);
            array_push($plansAttributes, (array) $recipe);
        }

        $exercisesList = array_combine($exercisesIds, $exercisesAttributes);
        $recipesList = array_combine($plansIds, $plansAttributes);

        $routine->save();
        
        $routine->exercises()->sync($exercisesList);
        $routine->recipes()->sync($recipesList);
    }

    public function active() {
        $user = Auth::guard('api')->user();

        if($user != null) {
            if($user->profile) {
                return response()->json([
                    'data' => [
                        'status' => $user->profile->isActive() ? "activated" : "inactive"
                    ]
                ], 200);
            } else {
                return response()->json([
                    'data' => [
                        'status' => 'inactive'
                    ]
                ], 404);
            }
        } else {
            return response()->json([
                'data' => [
                    'error' => 'Unauthorized'
                ]
            ], 403);
        }
    }
}
