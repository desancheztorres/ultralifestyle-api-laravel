<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Target;

class TargetTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Target $target)
    {
        return [
            'id' => $target->id,
            'name' => $target->name,
            'slug' => $target->slug,
            'type' => $target->type,
        ];
    }
}
