<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeekDay extends Model
{
    public $timestamps = false;
    
    public function exercises() {
        $this->belongsToMany('App\Models\Exercise');
    }
}
