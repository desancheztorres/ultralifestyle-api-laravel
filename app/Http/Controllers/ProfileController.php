<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\Transformers\ProfileTransformer;
use App\Http\Requests\Profile\{StoreProfileRequest, UpdateProfileRequest};
use App\Models\{Preference, Profile, Routine, Plan, Target, Gender, Avatar};
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
        $target = Target::where('type', $request->target)->first();
        $preference = Preference::where('name', $request->preference)->first();
        $age = Carbon::parse($request->dob)->age;

        $nutrition = new MyNutrition();
        $bodyMetric = new BodyMetric($gender, $age, $height, $weight);

        $bmr = $bodyMetric->getBmr();

        switch($target->type) {
            case "lw":
                $nutrition->setNutritionValues(.50, .30, .20, -300, $bmr);
                break;
            case "gs":
                $nutrition->setNutritionValues(.40, .20, .40, 300, $bmr);
                break;
            case "mw":
                $nutrition->setNutritionValues(.40, .30, .20, 0, $bmr);
                break;
            default :
                $nutrition->setNutritionValues(.20, .20, .20, 0, $bmr);
        }

        $profile->dob = $request->dob;
        $profile->height = $height;
        $profile->weight = $weight;
        $profile->gender = $gender;
        $profile->preference_id = $preference->id;
        $profile->target_id = $target->id;
        $profile->user()->associate($request->user());
        $profile->bmi = $request->bmi;
        $profile->bmr = $bmr;
        $profile->calories = $nutrition->getCalories();
        $profile->calories_used = 0;
        $profile->protein = $nutrition->getProtein();
        $profile->fat = $nutrition->getFat();
        $profile->carb = $nutrition->getCarb();

        $profile->save();

        $profile->avatar()->save(new Avatar());

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

        if($user->hasCreatedProfile()) {
            return response()->json([
                'data' => [
                    'status' => "activated"
                ]
            ], 200);
        } else {
            return response()->json([
                'data' => [
                    'status' => 'inactive'
                ]
            ], 404);
        }

    }
}
