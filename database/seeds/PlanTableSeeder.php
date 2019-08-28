<?php

use Illuminate\Database\Seeder;

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plansList = ["Lose Weight", "Build Muscle", "Maintenance"];
        foreach($plansList as $plan) {
            DB::table('plans')->insert([
                'name' => $plan,
                'description' => "Description for the routine ".$plan,
                'user_id' => 11,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
