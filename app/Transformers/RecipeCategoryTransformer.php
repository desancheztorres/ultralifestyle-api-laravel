<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\RecipeCategory;

class RecipeCategoryTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(RecipeCategory $recipeCategory)
    {
        return [
            'id' => $recipeCategory->id,
            'name' => $recipeCategory->name,
            'image' => $recipeCategory->image,
        ];
    }
}
