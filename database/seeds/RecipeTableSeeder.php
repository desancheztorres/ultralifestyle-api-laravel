<?php

use Illuminate\Database\Seeder;

class RecipeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $recipesList = ['Million-Dollar Spaghetti', 'Slow Cooker Pork Rib Tips', 'Honey Grilled Shrimp', 'Peach Cobbler Dump Cake I', 'Low Carb Yellow Squash Casserole'];

        foreach ($recipesList as $recipe) {
            DB::table('recipes')->insert([
                'name' => $name = $recipe,
                'description' => "Description for ".$name,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
