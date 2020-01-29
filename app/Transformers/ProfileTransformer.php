<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Profile;

class ProfileTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Profile $profile
     * @return array
     */
    public function transform(Profile $profile)
    {
        return [
            'id' => $profile->id,
            'name' => $profile->user->name,
            'email' => $profile->user->email,
            'avatar' => $profile->avatar->image ? $profile->avatar->image : null,
            'dob' => $profile->dob,
            'gender' => $profile->gender,
            'height' => $profile->height,
            'weight' => $profile->weight,
            'preference' => $profile->preference->name,
            'target' => $profile->target->name,
            'bmi' => number_format($profile->bmi, 1, '.', ''),
            'bmr' => number_format($profile->bmr, 1, '.', ''),
            'calories' => number_format($profile->calories, 1, '.', ''),
            'calories_used' => $profile->calories_used,
            'fat' => $profile->fat,
            'protein' => $profile->protein,
            'carb' => $profile->carb,
            'created_at' => $profile->created_at->toDateTimeString(),
            'updated_at' => $profile->updated_at->toDateTimeString(),
            'created_at_human' => $profile->created_at->diffForHumans(),
        ];
    }
}
