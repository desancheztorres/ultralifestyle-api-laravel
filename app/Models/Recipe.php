<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Orderable;

class Recipe extends Model
{
    use Orderable;

    public function routines() {
        return $this->belongsToMany('App\Models\Routine');
    }
}
