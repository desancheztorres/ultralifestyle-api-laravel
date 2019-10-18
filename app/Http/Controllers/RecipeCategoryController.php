<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecipeCategory;
use App\Transformers\RecipeCategoryTransformer;
use App\Http\Requests\StoreRecipeCategoryRequest;
use App\Http\Requests\UpdateRecipeCategoryRequest;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;


class RecipeCategoryController extends Controller
{
    public function index() {
        $categories = RecipeCategory::latestFirst()->get();

        return fractal()
            ->collection($categories)
            ->transformWith(new RecipeCategoryTransformer)
            ->toArray();
    }

    public function show(RecipeCategory $category) {
        return fractal()
            ->item($category)
            ->transformWith(new RecipeCategoryTransformer)
            ->toArray();
    }

    public function store(StoreRecipeCategoryRequest $request) {
        $recipeCategory = new RecipeCategory;
        $recipeCategory->name = $request->name;
        $recipeCategory->slug = str_slug($request->name);
        $recipeCategory->description = $request->description;
        $recipeCategory->image = $request->image;

        $recipeCategory->save();

        return fractal()
            ->item($recipeCategory)
            ->transformWith(new RecipeCategoryTransformer)
            ->toArray();
    }

    public function update(UpdateRecipeCategoryRequest $request, RecipeCategory $recipeCategory) {
        $recipeCategory->name = $request->get('name', $recipeCategory->name);
        $recipeCategory->slug = str_slug($request->name);
        $recipeCategory->image = $request->get('image', $recipeCategory->image);
        $recipeCategory->description = $request->get('description', $recipeCategory->description);
        $recipeCategory->save();

        return fractal()
            ->item($recipeCategory)
            ->transformWith(new RecipeCategoryTransformer)
            ->toArray();
    }

    public function destroy(RecipeCategory $recipeCategory) {
        $recipeCategory->delete();

        return response(null, 204);
    }
}
