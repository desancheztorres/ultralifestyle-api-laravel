<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Recipe;

class RecipeTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Recipe $recipe)
    {
        return [
            'id' => $recipe->id,
            'name' => $recipe->name,
            'description' => $recipe->description,
        ];
    }
}
