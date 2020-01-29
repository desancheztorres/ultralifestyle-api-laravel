<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Avatar;

class AvatarTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Avatar $avatar)
    {
        return [
            'image' => $avatar->image,
        ];
    }
}
