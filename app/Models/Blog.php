<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Orderable;

class Blog extends Model
{
    use Orderable;

    protected $fillable = ['title', 'image', 'description'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function posts() {
        return $this->hasMany(Post::class)->oldestFirst();
    }
}
