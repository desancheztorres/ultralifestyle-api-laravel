<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Orderable;

class Routine extends Model
{
    use Orderable;

    protected $fillable = ['name', 'description'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function exercises() {
        return $this->belongsToMany('App\Models\Exercise');
    }

    public function recipes() {
        return $this->belongsToMany('App\Models\Recipe');
    }
}
