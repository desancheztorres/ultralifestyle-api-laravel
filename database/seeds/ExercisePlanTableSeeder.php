<?php

use Illuminate\Database\Seeder;

class ExercisePlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $plan1 = [1,6,8,9,90,98,100,56];
        $plan2 = [120,87,99,32,5,6,7,9,11];
        $plan3 = [87,134,123,4,5,7,11,23,24,27,29];

        foreach ($plan1 as $p) {
            DB::table('exercise_plan')->insert([
                'plan_id' => 1,
                'exercise_id' =>$p,
                'sets' => rand(1,4),
                'reps' => rand(8,12),
                'week_day_id' => rand(1,7),
            ]);
        }

        foreach ($plan2 as $p) {
            DB::table('exercise_plan')->insert([
                'plan_id' => 2,
                'exercise_id' =>$p,
                'sets' => rand(1,4),
                'reps' => rand(8,12),
                'week_day_id' => rand(1,7),
            ]);
        }

        foreach ($plan3 as $p) {
            DB::table('exercise_plan')->insert([
                'plan_id' => 3,
                'exercise_id' =>$p,
                'sets' => rand(1,4),
                'reps' => rand(8,12),
                'week_day_id' => rand(1,7),
            ]);
        }
    }
}
