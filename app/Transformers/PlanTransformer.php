<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Plan;

class PlanTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['user', 'exercises'];
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Plan $plan)
    {
        return [
            'id' => $plan->id,
            'title' => $plan->name,
            'description' => $plan->description,
            'created_at' => $plan->created_at->toDateTimeString(),
            'created_at_human' => $plan->created_at->diffForHumans(),
        ];
    }

    public function includeUser(Plan $plan) {
        return $this->item($plan->user, new UserTransformer);
    }

    public function includeExercises(Plan $plan) {
        return $this->collection($plan->exercises, new ExerciseTransformer);
    }
}
