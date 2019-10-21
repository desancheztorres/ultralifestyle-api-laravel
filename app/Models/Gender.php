<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function profile() {
        return $this->hasMany(Profile::class);
    }
}