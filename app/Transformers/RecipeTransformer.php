<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Recipe;

class RecipeTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['category'];

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
            'image' => $recipe->image,
            'ingredients' => $recipe->ingredients,
            'instructions' => $recipe->instructions,
            'prep' => $recipe->prep,
            'cook' => $recipe->cook,
            'ready_in' => $recipe->ready_in,
            'calories' => $recipe->calories,
            'protein' => number_format((float) $recipe->protein, 2, '.', ''),
            'carb' => number_format((float) $recipe->carb, 2, '.', ''),
            'fat' => number_format((float) $recipe->fat, 2, '.', ''),
            'author' => $recipe->author,
            'link' => $recipe->link,

        ];
    }

    public function includeCategory(Recipe $recipe) {
        return $this->item($recipe->category, new RecipeCategoryTransformer);
    }
}
