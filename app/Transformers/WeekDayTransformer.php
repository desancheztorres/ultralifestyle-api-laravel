<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\WeekDay;

class WeekDayTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(WeekDay $weekDay)
    {
        return [
            'id' => $weekDay->id,
            'name' => $weekDay->name,
        ];
    }
}
