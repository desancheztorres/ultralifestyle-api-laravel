<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Weight;

class WeightTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Weight $weight)
    {
        return [
            'id' => $weight->id,
            'weight' => number_format($weight->weight, 1, '.', ''),
            'created_at' => $weight->created_at->toDateTimeString(),
            'created_at_human' => $weight->created_at->diffForHumans(),
        ];
    }
}
