<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(UsersTableSeeder::class);
//        $this->call(WeekDaysTableSeeder::class);
//        $this->call(ExercisesTableSeeder::class);
//        $this->call(RoutineTableSeeder::class);
//        $this->call(BodyPartsTableSeeder::class);
        $this->call(PlanTableSeeder::class);
    }
}