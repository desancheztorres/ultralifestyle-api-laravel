<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Orderable;

class Plan extends Model
{
    use Orderable;
    protected $fillable = ["name", "description"];

    public function exercises() {
        return $this->belongsToMany("App\Models\Exercise");
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
