<?php

use Illuminate\Database\Seeder;

class BodyPartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bodyPartsList = ["Any body part", "Core", "Arms", "Back", "Chest", "Legs", "Shoulders", "Other", "Olympic", "Full body", "Cardio"];

        foreach ($bodyPartsList as $item) {
            DB::table('body_parts')->insert([
                'name' => $name = $item,
                'description' => "Description for " . $name,
            ]);
        }
    }
}