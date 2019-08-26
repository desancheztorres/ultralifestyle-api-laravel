<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    public function routines() {
        return $this->belongsToMany('App\Models\Routine');
    }

    public function weekday() {
        return $this->belongsTo('App\Models\WeekDay');
    }
}
