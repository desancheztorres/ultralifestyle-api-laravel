<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Gender;

class GenderTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Gender $gender)
    {
        return [
            'id' => $gender->id,
            'name' => $gender->name,
        ];
    }
}
