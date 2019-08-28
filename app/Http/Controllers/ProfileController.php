<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use App\Transformers\ProfileTransformer;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Policies\ProfilePolicy;

class ProfileController extends Controller
{
    public function show(User $user) {

        $profile = Profile::where('user_id', $user->id);

        return fractal()
            ->collection($profile)
            ->parseIncludes(['user'])
            ->transformWith(new ProfileTransformer)
            ->toArray();
    }

    public function store(StoreProfileRequest $request) {

        $profile = new Profile();

        $this->authorize('profile', $profile);

        $profile->dob = $request->dob;
        $profile->height = $request->height;
        $profile->weight = $request->weight;
        $profile->gender = $request->gender;
        $profile->ethnic = $request->ethnic;
        $profile->user()->associate($request->user());

        $profile->save();

        return fractal()
            ->item($profile)
            ->parseIncludes(['user'])
            ->transformWith(new ProfileTransformer)
            ->toArray();

    }

    public function update(UpdateProfileRequest $request, User $user, Profile $profile) {

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
}
