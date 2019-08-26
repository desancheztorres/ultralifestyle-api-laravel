<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Routine;
use App\Transformers\WeekDayTransformer;
class RoutineTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['user', 'exercises'];
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Routine $routine)
    {
        return [
            'id' => $routine->id,
            'title' => $routine->name,
            'description' => $routine->description,
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
