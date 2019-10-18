<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Transformers\RecipeTransformer;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;

class RecipeController extends Controller
{
    public function index() {
        $recipes = Recipe::latestFirst()->get();

        return fractal()
            ->collection($recipes)
            ->transformWith(new RecipeTransformer)
            ->toArray();

    }

    public function show(Recipe $recipe) {
        return fractal()
            ->item($recipe)
            ->transformWith(new RecipeTransformer)
            ->toArray();
    }

    public function store(StoreRecipeRequest $request) {
        $recipe = new Recipe;
        $recipe->name = $request->name;
        $recipe->description = $request->description;

        $recipe->save();

        return fractal()
            ->item($recipe)
            ->transformWith(new RecipeTransformer)
            ->toArray();
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe) {

        $recipe->name = $request->get('name', $recipe->name);
        $recipe->description = $request->get('description', $recipe->description);
        $recipe->save();

        return fractal()
            ->item($recipe)
            ->transformWith(new RecipeTransformer)
            ->toArray();
    }

    public function destroy(Recipe $recipe) {
        $recipe->delete();

        return response(null, 204);
    }

    public function category($category) {
        $recipes = Recipe::where('category_id', $category)->get();

        return fractal()
            ->collection($recipes)
            ->transformWith(new RecipeTransformer)
            ->toArray();
    }
}
