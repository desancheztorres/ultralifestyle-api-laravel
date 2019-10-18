<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['gender', 'height', 'weight', 'dob', 'ethnic', 'target'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function isActive() {
        return $this->status ? true : false;
    }

    public function gender() {
        return $this->belongsTo(Gender::class);
    }

    public function ethnic() {
        return $this->belongsTo(Ethnic::class);
    }

    public function target() {
        return $this->belongsTo(Target::class);
    }
}
