<?php

use Illuminate\Database\Seeder;

class RecipePlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plan1 = [4,5,6,9,12,13];
        $plan2 = [1,2,3,7];
        $plan3 = [2,4,8,13];

        foreach ($plan1 as $p) {
            DB::table('recipe_plan')->insert([
                'plan_id' => 1,
                'recipe_id' =>$p,
                'week_day_id' => rand(1,7),
            ]);
        }

        foreach ($plan2 as $p) {
            DB::table('recipe_plan')->insert([
                'plan_id' => 2,
                'recipe_id' =>$p,
                'week_day_id' => rand(1,7),
            ]);
        }

        foreach ($plan3 as $p) {
            DB::table('recipe_plan')->insert([
                'plan_id' => 3,
                'recipe_id' =>$p,
                'week_day_id' => rand(1,7),
            ]);
        }
    }
}
