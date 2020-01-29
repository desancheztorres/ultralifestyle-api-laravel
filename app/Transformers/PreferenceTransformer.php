<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Preference;

class PreferenceTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Preference $preference)
    {
        return [
            'id' => $preference->id,
            'name' => $preference->name
        ];
    }
}
