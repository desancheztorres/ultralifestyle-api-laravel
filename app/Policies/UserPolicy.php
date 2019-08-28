<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $user) {
        return Auth::guard('api')->id() === $user->id;
    }
}
