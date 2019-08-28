<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['gender', 'height', 'weight', 'dob', 'ethnic', 'target'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
