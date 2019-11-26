<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\PlanUser;

class PlanUserTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['plan', 'exercises'];

    public function transform(PlanUser $planUser)
    {
        return [
            'id' => $planUser->id,
        ];
    }

    public function includeUser(PlanUser $planUser) {
        return $this->item($planUser->user, new UserTransformer);
    }

    public function includePlan(PlanUser $planUser) {
        return $this->item($planUser->plan, new PlanTransformer);
    }

    public function includeExercises(PlanUser $planUser) {
        return $this->collection($planUser->exercises, new ExerciseTransformer);
    }
}
