<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Plan;

class PlanTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['exercises'];
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Plan $plan)
    {
        return [
            'id' => $plan->id,
            'name' => $plan->name,
            'image' => $plan->image,
            'description' => $plan->description,
            'goal' => $plan->goal,
            'days_week' => $plan->days_week,
            'avg_time' => $plan->avg_time,
            'created_at' => $plan->created_at->toDateTimeString(),
            'created_at_human' => $plan->created_at->diffForHumans(),
        ];
    }

    public function includeExercises(Plan $plan) {
        return $this->collection($plan->exercises, new ExerciseTransformer);
    }
}
