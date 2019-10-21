<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\BodyPart;

class BodyPartTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(BodyPart $bodyPart)
    {
        return [
            'id' => $bodyPart->id,
            'name' => $bodyPart->name,
            'image' => $bodyPart->image,
        ];
    }
}
