<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Ethnic;

class EthnicTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Ethnic $ethnic)
    {
        return [
            'id' => $ethnic->id,
            'name' => $ethnic->name,
        ];
    }
}
