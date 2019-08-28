<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Profile;

class ProfileTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['user'];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Profile $profile)
    {
        return [
            'id' => $profile->id,
            'gender' => $profile->gender,
            'dob' => $profile->dob,
            'height' => $profile->height,
            'weight' => $profile->weight,
            'ethnic' => $profile->ethnic,
            'created_at' => $profile->created_at->toDateTimeString(),
            'updated_at' => $profile->updated_at->toDateTimeString(),
            'created_at_human' => $profile->created_at->diffForHumans(),
        ];
    }

    public function includeUser(Profile $profile) {
        return $this->item($profile->user, new UserTransformer);
    }
}
