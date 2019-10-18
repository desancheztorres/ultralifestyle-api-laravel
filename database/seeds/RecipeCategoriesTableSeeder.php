<?php

use Illuminate\Database\Seeder;

class RecipeCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/recipe_categories.json");
        $data = json_decode($json);

        foreach ($data as $obj) {

            DB::table('recipe_categories')->insert([
                'name' => $name = $obj->name,
                'image' => $obj->image,
                'slug' => str_slug($obj->name),
            ]);
        }
    }
}
