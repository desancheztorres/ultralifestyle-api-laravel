<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Orderable;

class BodyPart extends Model
{
    protected $fillable = ['name', 'description'];
    
    public $timestamps = false;
    
    use Orderable;

    public function exercises() {
        return $this->belongsToMany('App\Models\Exercise');
    }
}
