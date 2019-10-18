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
        $json = File::get("database/data/body_parts.json");
        $bodyParts = json_decode($json);

        foreach ($bodyParts as $item) {
            DB::table('body_parts')->insert([
                'name' => $name = $item,
                'image' => strtolower(str_replace(' ', '_', $name).'.png'),
            ]);
        }
    }
}