<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Exercise;

class ExerciseTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Exercise $exercise)
    {
        return [
            'id' => $exercise->id,
            'name' => $exercise->name,
            'description' => $exercise->description,
        ];
    }

}
