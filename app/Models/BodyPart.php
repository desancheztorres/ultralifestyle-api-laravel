<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BodyPart extends Model
{
    public function exercises() {
        return $this->belongsToMany('App\Models\Exercise');
    }
}
