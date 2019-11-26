<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Orderable;

class Routine extends Model
{
    use Orderable;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function exercises() {
        return $this->belongsToMany(Exercise::class)->withPivot('sets', 'reps', 'kg', 'time', 'completed', 'order', 'week_day_id')->withTimestamps();
    }

    public function recipes() {
        return $this->belongsToMany(Recipe::class);
    }
}
