<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['gender', 'height', 'weight', 'dob', 'ethnic', 'target'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function isActive() {
        return $this->status ? true : false;
    }

    public function preference() {
        return $this->belongsTo(Preference::class);
    }

    public function target() {
        return $this->belongsTo(Target::class);
    }

    public function level() {
        return $this->belongsTo(ExperienceLevel::class);
    }

    public function avatar() {
        return $this->hasOne(Avatar::class);
    }
}
