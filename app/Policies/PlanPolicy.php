<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Plan;

class PlanPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Plan $plan)
    {
        return $user->ownsPlans($plan);
    }

    public function destroy(User $user, Plan $plan)
    {
        return $user->ownsPlans($plan);
    }
}
