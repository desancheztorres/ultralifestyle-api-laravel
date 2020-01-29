<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    public function profile() {
        return $this->hasMany(Profile::class);
    }
}
