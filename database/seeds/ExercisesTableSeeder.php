<?php

use Illuminate\Database\Seeder;

class ExercisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/exercises.json");
        $exercises = json_decode($json);

        foreach ($exercises as $exercise) {
            DB::table('exercises')->insert([
                'name' => $name = $exercise,
                'image' => str_slug($name) . '.png',
                'description' => "Description for ".$name,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
