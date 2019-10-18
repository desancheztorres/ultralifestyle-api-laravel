<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Plan::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->sentence($nbWords = 6, $variableNbWords = true),
        'slug' => str_slug($name),
        'description' =>$faker->text($maxNbChars = 200),
        'image' => $faker->imageUrl($width = 640, $height = 480),
        'goal' => $faker->word,
        'days_week' => $faker->randomNumber($nbDigits = 1, $strict = false),
        'avg_time' => $faker->randomNumber($nbDigits = 2, $strict = false),
    ];
});
