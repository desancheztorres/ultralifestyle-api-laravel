<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Orderable;

class Exercise extends Model
{
    use Orderable;

    public function routines() {
        return $this->belongsToMany('App\Models\Routine')->withPivot('sets', 'reps', 'week_day_id')->withTimestamps();
    }

    public function plans() {
        return $this->belongsToMany('App\Models\Plan')->withPivot('sets', 'reps', 'week_day_id')->withTimestamps();
    }

    public function bodyParts() {
        return $this->belongsToMany('App\Models\BodyPart');
    }

    public function weekday() {
        return $this->belongsTo('App\Models\WeekDay');
    }
}
