<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ExperienceLevel;

class ExperienceLevelTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(ExperienceLevel $level)
    {
        return [
            'id' => $level->id,
            'name' => $level->name
        ];
    }
}
