<?php

namespace App\Library;

class Nutrition {
    private $protein;
    private $fat;
    private $carb;
    private $calories;

    public function getProtein() {
        return $this->protein;
    }

    public function setProtein($protein) {
        $this->protein = $protein;
    }

    public function getFat() {
        return $this->fat;
    }

    public function setFat($fat) {
        $this->fat = $fat;
    }

    public function getCarb() {
        return $this->carb;
    }

    public function setCarb($carb) {
        $this->carb = $carb;
    }

    public function getCalories() {
        return $this->calories;
    }

    public function setCalories($calories) {
        $this->calories = $calories;
    }

    public function setNutritionValues($protein, $carb, $fat, $calories, $bmr) {
        $this->setProtein(round(($bmr * $protein) / 4));
        $this->setFat(round(($bmr * $carb) / 9));
        $this->setCarb(round(($bmr * $fat) / 4));
        $this->setCalories($bmr + ($calories));
    }

}