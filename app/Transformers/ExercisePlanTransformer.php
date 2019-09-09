<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ExercisePlan;

class ExercisePlanTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(ExercisePlan $exercisePlan)
    {
        return [
            'id' => $exercisePlan->id,
            'plan_id' => $exercisePlan->plan_id,
            'exercise_id' => $exercisePlan->exercise_id,
            'sets' => $exercisePlan->sets,
            'reps' => $exercisePlan->reps,
            'week_day_id' => $exercisePlan->week_day_id,
        ];
    }
}
