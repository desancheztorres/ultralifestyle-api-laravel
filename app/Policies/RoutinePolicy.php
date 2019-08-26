<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Routine;

class RoutinePolicy
{
    use HandlesAuthorization;

    public function show(User $user, Routine $routine)
    {
        return $user->ownsRoutines($routine);
    }

    public function update(User $user, Routine $routine)
    {
        return $user->ownsRoutines($routine);
    }

    public function destroy(User $user, Routine $routine)
    {
        return $user->ownsRoutines($routine);
    }
}
