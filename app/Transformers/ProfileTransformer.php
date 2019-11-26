<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Profile;

class ProfileTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['user', 'target', 'ethnic'];

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
            'dob' => $profile->dob,
            'gender' => $profile->gender,
            'height' => number_format($profile->height, 2, '.', ''),
            'weight' => number_format($profile->weight, 1, '.', ''),
            'bmi' => number_format($profile->bmi, 2, '.', ''),
            'bmr' => $profile->bmr,
            'calories' => $profile->calories,
            'calories_used' => $profile->calories_used,
            'fat' => $profile->fat,
            'protein' => $profile->protein,
            'carb' => $profile->carb,
            'created_at' => $profile->created_at->toDateTimeString(),
            'updated_at' => $profile->updated_at->toDateTimeString(),
            'created_at_human' => $profile->created_at->diffForHumans(),
        ];
    }

    public function includeUser(Profile $profile) {
        return $this->item($profile->user, new UserTransformer);
    }

    public function includeTarget(Profile $profile) {
        return $this->item($profile->target, new TargetTransformer);
    }

    public function includeEthnic(Profile $profile) {
        return $this->item($profile->ethnic, new EthnicTransformer);
    }
}
