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
        $json = File::get("database/data/recipes.json");
        $data = json_decode($json);

        foreach ($data as $obj) {

            DB::table('recipes')->insert([
                'name' => $name = $obj->name,
                'image' => $obj->image,
                'category_id' => $obj->category_id,
                'description' => "Description for ".$name,
                'protein' => $obj->protein,
                'carb' => $obj->carb,
                'fat' => $obj->fat,
                'calories' => $obj->calories,
                'ready_in' => $obj->ready_in,
                'cook' => $obj->cook,
                'prep' => $obj->prep,
                'ingredients' => $obj->ingredients,
                'instructions' => $obj->instructions,
                'author' => $obj->author,
                'link' => $obj->link,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
