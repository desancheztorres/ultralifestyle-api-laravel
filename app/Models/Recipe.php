<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Orderable;

class Recipe extends Model
{
    use Orderable;

    public function routines() {
        return $this->belongsToMany('App\Models\Routine')->withPivot('week_day_id')->withTimestamps();
    }

    public function plans() {
        return $this->belongsToMany('App\Models\Plan')->withPivot('week_day_id')->withTimestamps();
    }

    public function category() {
        return $this->belongsTo(RecipeCategory::class);
    }
}
