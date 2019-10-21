<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExperienceLevel extends Model
{

    public $timestamps = false;

    public function profile() {
        return $this->hasMany(Profile::class);
    }
}
