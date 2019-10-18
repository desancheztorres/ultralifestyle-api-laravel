<?php

use Illuminate\Database\Seeder;

class TargetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/targets.json');
        $targets = json_decode($json);

        foreach ($targets as $target) {
            DB::table('targets')->insert([
                'name' => $name = $target,
                'slug' => str_slug($name),
            ]);
        }
    }
}
