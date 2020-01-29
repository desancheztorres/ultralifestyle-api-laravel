<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    public $timestamps = false;

    public function profile() {
        return $this->belongsTo(Profile::class);
    }
}
