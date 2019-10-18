<?php

use Illuminate\Database\Seeder;

class EthnicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/ethnics.json');
        $ethnics = json_decode($json);

        foreach($ethnics as $ethnic) {
            DB::table('ethnics')->insert([
                'name' => $name = $ethnic,
                'slug' => str_slug($name),
            ]);
        }
    }
}
