<?php

use Illuminate\Database\Seeder;

class WeekDaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

        $day_number = 0;

        foreach ($days as $day) {
            
            $day_number++;

            DB::table('week_days')->insert([
                'name' => $day,
                'day_number' => $day_number,
            ]);
        }
    }
}
