<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Exercise;
use App\Transformers\BodyPart;

class ExerciseTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['body_part'];
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

    public function includeBodyPart(Exercise $exercise) {
        return $this->collection($exercise->bodyParts, new BodyPartTransformer);
    }

}
