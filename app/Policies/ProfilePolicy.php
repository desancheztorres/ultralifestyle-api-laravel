<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy
{
    use HandlesAuthorization;

    public function profile(User $user, Profile $profile) {
        return !$user->hasCreatedProfile($profile);
    }

    public function update(User $user, Profile $profile)
    {
        return $user->ownsProfile($profile);
    }

    public function destroy(User $user, Profile $profile)
    {
        return $user->ownsProfile($profile);
    }
}
