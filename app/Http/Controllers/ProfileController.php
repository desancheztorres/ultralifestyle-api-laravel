<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use App\Transformers\ProfileTransformer;#
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Policies\ProfilePolicy;
use App\Models\Routine;
use App\Models\Plan;
use App\Models\Exercise;
use Carbon\Carbon;


class ProfileController extends Controller
{
    private $protein;
    private $fat;
    private $carb;
    private $calories;
    private $bmr;

    public function index() {
        $profiles = Profile::get();

        dd($profiles);
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
        $profile = new Profile();

        $this->authorize('profile', $profile);

        $height = $request->get('height');
        $weight = $request->get('weight');
        $bmi = $this->calculateBmi(false, $weight, $height);
        $age = Carbon::parse($request->dob)->age;
        $bmr = $this->calculateBMR($request->gender, $age, $height, $weight);
        $this->bmr = $bmr;

        switch($request->get('target')) {
            case "Lose Weight":
                $this->checkTarget(.50, .30, .20, -300);
                break;
            case "Build Muscle":
                $this->checkTarget(.40, .20, .40, 300);
                break;
            case "Maintenance":
                $this->checkTarget(.40, .30, .20, 0);
                break;
            default :
                $this->checkTarget(.20, .20, .20, 0);
        }

        $profile->dob = $request->dob;
        $profile->height = $request->height;
        $profile->weight = $request->weight;
        $profile->gender_id = $request->gender_id;
        $profile->ethnic_id = $request->ethnic_id;
        $profile->target_id = $request->target_id;
        $profile->user()->associate($request->user());
        $profile->bmi = (float) number_format($bmi, 2, '.', ',');
        $profile->bmr = $bmr;
        $profile->calories = $this->calories;
        $profile->calories_used = 0;
        $profile->protein = $this->protein;
        $profile->fat = $this->fat;
        $profile->carb = $this->carb;

        $profile->save();

        $target = $profile->target;

        $this->createUserRoutine($target);

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
        $gender = $request->get('gender', $profile->gender);
        $dob = $request->get('dob', $profile->dob);
        $target = $request->get('target', $profile->target);
        $age = Carbon::parse($dob)->age;
        $bmi = $this->calculateBmi(false, $weight, $height);
        $bmr = $this->calculateBMR($request->gender, $age, $height, $weight);
        $this->bmr = $bmr;

        switch($target) {
            case "Lose Weight":
                $this->checkTarget(.50, .30, .20, -300);
                break;
            case "Build Muscle":
                $this->checkTarget(.40, .20, .40, 300);
                break;
            case "Maintenance":
                $this->checkTarget(.40, .30, .20, 0);
                break;
            default :
                $this->checkTarget(.20, .20, .20, 0);
        }

        $profile->dob = $dob;
        $profile->height = $request->get('height', $profile->height);
        $profile->weight = $request->get('weight', $profile->weight);
        $profile->gender = $gender;
        $profile->ethnic = $request->get('ethnic', $profile->ethnic);
        $profile->target = $target;
        $profile->bmi = number_format($bmi, 2, '.', ',');
        $profile->bmr = $bmr;
        $profile->calories = $this->calories;
        $profile->protein = $this->protein;
        $profile->fat = $this->fat;
        $profile->carb = $this->carb;
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

    private function checkTarget($protein, $carb, $fat, $calories) {
        $this->protein = round(($this->bmr * $protein) / 4);
        $this->fat = round(($this->bmr * $carb) / 9);
        $this->carb = round(($this->bmr * $fat) / 4);
        $this->calories = $this->bmr + ($calories);
    }

    private function calculateBmi($inCm, $weight, $height) {
        $bmi = (($weight / $height) / $height);

        if($inCm) {
            $bmi *= 10000;
        }

        return $bmi;
    }

    private function calculateBMR($gender, $age, $height, $weight) {

        switch($gender) {
            case "male":
                $bmr = 66.4730 + (13.7516 * $weight) + (5.0033 * $height) - (6.7550 * $age);
                break;
            case "female":
                $bmr = 655.0955 + (9.5634 * $weight) + (1.8496 * $height) - (4.6756 * $age);
                break;
            default:
                $bmr = 66 + (13.7 * $weight) + (5 * $height) - (6.75 * $age);
        }

        $calories = (int) number_format($bmr, 0,'.', '');

        return $calories;
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
