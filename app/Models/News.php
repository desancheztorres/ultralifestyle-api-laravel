<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Orderable;

class News extends Model
{
    use Orderable;

    protected $fillable = ['title', 'image', 'description', 'body', 'author', 'author_image', 'url'];
}
