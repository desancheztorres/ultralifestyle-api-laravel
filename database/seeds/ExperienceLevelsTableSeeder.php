<?php

use Illuminate\Database\Seeder;

class ExperienceLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levels = ['Beginner', 'Intermediate', 'Expert'];

        foreach ($levels as $level) {
            DB::table('experience_levels')->insert([
                'name' => $name= $level,
                'slug' => str_slug($name),
            ]);
        }
    }
}
