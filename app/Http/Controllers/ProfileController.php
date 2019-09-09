<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use App\Transformers\ProfileTransformer;#
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Policies\ProfilePolicy;
use Auth;
use App\Models\Routine;
use App\Models\Plan;
use App\Models\Exercise;
use DB;

class ProfileController extends Controller
{
    public function show() {

        $userId = Auth::guard('api')->id();

        $profile = Profile::where('user_id', $userId)->get();

        return fractal()
            ->collection($profile)
            ->parseIncludes(['user'])
            ->transformWith(new ProfileTransformer)
            ->toArray();
    }

    public function store(StoreProfileRequest $request) {

        $userId = Auth::guard('api')->id();
        $profile = new Profile();

//        $this->authorize('profile', $profile);

        $profile->dob = $request->dob;
        $profile->height = $request->height;
        $profile->weight = $request->weight;
        $profile->gender = $request->gender;
        $profile->ethnic = $request->ethnic;
        $profile->target = $request->target;
        $profile->user()->associate($request->user());
        $profile->bmi = ($request->weight / $request->height) / $request->height;

        User::where('status', 0)
            ->where('id', $userId)
            ->update(['status' => 1]);

        $profile->save();


        $this->createUserRoutine($request->target);

        return fractal()
            ->item($profile)
            ->parseIncludes(['user'])
            ->transformWith(new ProfileTransformer)
            ->toArray();
    }

    public function update(UpdateProfileRequest $request, Profile $profile) {

        $this->authorize('update', $profile);

        $profile->dob = $request->get('dob', $profile->dob);
        $profile->height = $request->get('height', $profile->height);
        $profile->weight = $request->get('weight', $profile->weight);
        $profile->gender = $request->get('gender', $profile->gender);
        $profile->ethnic = $request->get('ethnic', $profile->ethnic);

        $profile->save();

        return fractal()
            ->item($profile)
            ->parseIncludes(['user'])
            ->transformWith(new ProfileTransformer)
            ->toArray();
    }

    public function destroy() {

        $userId = Auth::guard('api')->id();

        $profile = Profile::where('user_id', $userId);

//        $this->authorize('destroy', $profile);

        User::where('status', 1)
            ->where('id', $userId)
            ->update(['status' => 0]);

        $profile->delete();

        return response(null, 204);
    }

    public function createUserRoutine($target) {
        $user = Auth::guard('api')->user();

        $routine = new Routine();

        $routine->name = $target;
        $routine->description = $target;
        $routine->user()->associate($user->id);

        $plan = Plan::where('name', $target)->first();

        $exercisesIds = array();

        $exercisesAttributes = array();

        if($plan->name == "Lose Weight") {

            $exercisePlans = DB::table('exercise_plan')
                ->select('exercise_id', 'reps', 'sets', 'week_day_id')
                ->where('plan_id', $plan->id)->get()->toArray();

            foreach ($exercisePlans as $exercise) {
                array_push($exercisesIds,$exercise->exercise_id);
                array_push($exercisesAttributes, (array) $exercise);
            }

        }

        if($plan->name == "Build Muscle") {

            $exercisePlans = DB::table('exercise_plan')
                ->select('exercise_id', 'reps', 'sets', 'week_day_id')
                ->where('plan_id', $plan->id)->get()->toArray();

            foreach ($exercisePlans as $exercise) {
                array_push($exercisesIds,$exercise->exercise_id);
                array_push($exercisesAttributes, (array) $exercise);
            }

        }

        if($plan->name == "Maintenance") {

            $exercisePlans = DB::table('exercise_plan')
                ->select('exercise_id', 'reps', 'sets', 'week_day_id')
                ->where('plan_id', $plan->id)->get()->toArray();

            foreach ($exercisePlans as $exercise) {
                array_push($exercisesIds,$exercise->exercise_id);
                array_push($exercisesAttributes, (array) $exercise);
            }

        }

        $exercisesList = array_combine($exercisesIds, $exercisesAttributes);


        $routine->save();

        $routine->exercises()->sync($exercisesList);
    }
}
