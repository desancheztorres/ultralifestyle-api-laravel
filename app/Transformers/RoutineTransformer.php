<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Routine;

class RoutineTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Routine $routine)
    {
        return [
            'id' => $routine->id,
            'name' => $routine->name,
            'image' => $routine->image,
            'description' => $routine->description,
            'goal' => $routine->goal,
            'days_week' => $routine->days_week,
            'avg_time' => $routine->avg_time,
            'created_at' => $routine->created_at->toDateTimeString(),
            'created_at_human' => $routine->created_at->diffForHumans(),
        ];
    }

    public function includeUser(Routine $routine) {
        return $this->item($routine->user, new UserTransformer);
    }

    public function includeExercises(Routine $routine) {
        return $this->collection($routine->exercises, new ExerciseTransformer);
    }
}
