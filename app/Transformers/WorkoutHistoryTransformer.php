<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\WorkoutHistory;

class WorkoutHistoryTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['exercise'];


    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(WorkoutHistory $workoutHistory)
    {
        return [
            'id' => $workoutHistory->id,
            'set' => $workoutHistory->set,
            'reps' => $workoutHistory->reps,
            'kg' => $workoutHistory->kg,
            'time' => $workoutHistory->time,
            'created_at' => $workoutHistory->created_at,
        ];
    }

    public function includeUser(WorkoutHistory $workoutHistory) {
        return $this->item($workoutHistory->user, new UserTransformer);
    }

    public function includeExercise(WorkoutHistory $workoutHistory) {
        return $this->item($workoutHistory->exercise, new ExerciseTransformer);
    }
}
