<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Orderable;

class RecipeCategory extends Model
{
    use Orderable;

    protected $fillable = ['name', 'description', 'image'];

    public function recipes() {
        $this->hasMany(Recipe::class);
    }
}
