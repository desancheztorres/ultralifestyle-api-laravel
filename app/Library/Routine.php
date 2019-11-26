<?php

namespace App\Library;
use DB;


class Routine {
    private $exercises;
    private $recipes;
    private $exercisesIds = array();
    private $recipesIds = array();
    private $exercisesMapped;
    private $recipesMapped;

    public function __construct($exercises, $recipes)
    {
        $this->exercises = $exercises;
        $this->recipes = $recipes;
        $this->setExercisesIds();
        $this->setRecipesIds();
    }

    public function getExercises() {
        return $this->exercises;
    }

    public function setExercises($exercises) {
        $this->exercises = $exercises;
    }

    public function getRecipes() {
        return $this->recipes;
    }

    public function setRecipes($recipes) {
        $this->recipes = $recipes;
    }

    public function getExercisesMapped() {
        return $this->exercisesMapped;
    }

    public function setExercisesMapped($exercises) {
        $this->exercisesMapped = $exercises;
    }

    public function getRecipesMapped() {
        return $this->recipesMapped;
    }

    public function setRecipesMapped($recipes) {
        $this->recipesMapped = $recipes;
    }

    private function setExercisesIds() {

        if(is_null($this->exercises)) {
            return;
        }

        foreach($this->exercises as $exercise) {
            $arrayTemp = $exercise['exercise_id'];

            array_push($this->exercisesIds, $arrayTemp);
        }

        $this->exercisesMapped = array_combine($this->exercisesIds, $this->exercises);
    }

    private function setRecipesIds() {

        if(is_null($this->recipes)) {
            return;
        }

        foreach($this->recipes as $recipe) {
            $arrayTemp = $recipe['recipe_id'];

            array_push($this->recipesIds, $arrayTemp);
        }

        $this->recipesMapped = array_combine($this->recipesIds, $this->recipes);
    }

    public function deleteRecords($table, $routine, $weekday){
        DB::table($table)
            ->select('id')
            ->where('routine_id', $routine)
            ->where('week_day_id', $weekday)
            ->delete();
    }
}