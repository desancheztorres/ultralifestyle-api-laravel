<?php

use Illuminate\Database\Seeder;

class ExercisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exercisesList = [
            "Ab Wheel",
            "Aerobics",
            "Arm curl",
            "Arm machine",
            "Arnold Press (Dumbbell)",
            "Around the World",
            "Back Extension",
            "Back Extension (Machine)",
            "Ball Slams",
            "Battle Ropes",
            "Bench Dip",
            "Bench Press (Cable)",
            "Bench Press (Dumbbell)",
            "Bench Press (Smith Machine)",
            "Bench Press - Close Grip (Barbell)",
            "Bench Press - Wide Grip (Barbell)",
            "Bent Over One Arm Row",
            "Bent Over Row (Band)",
            "Bent Over Row (Barbell)",
            "Ben tOver Row (Dumbbell)",
            "Bent Over Row - Underhand",
            "Bicep Curl (Barbell)",
            "Bicep Curl (Cable)",
            "Bicep Curl (Dumbbell)",
            "Bicep Curl (Machine)",
            "Bycicle Crunch",
            "Box Jump",
            "Box Squat (Barbell)",
            "Bulgarian Split Squat",
            "Burpee",
            "Cable Crossover",
            "Cable Crunch",
            "Cable Kickback",
            "Cable Pull Through",
            "Cable Twist",
            "Calf Press on Leg Press",
            "Calf Press on Seated Leg Press",
            "Chest Dip",
            "Chest Dip (Assisted)",
            "Chest Fly",
            "Chest Fly (Band)",
            "Chest Press (Machine)",
            "Chin Up",
            "Chin Up (Assisted)",
            "Clean (Barbell)",
            "Clean and Jerk (Barbell)",
            "Climbing",
            "Concentration Curl (Dumbbell)",
            "Cross Body Crunch",
            "Crunch",
            "Crunch (Machine)",
            "Crunch (Stability Ball)",
            "Cycling",
            "Cycling (indoor)",
            "Deadlift (Band)",
            "Deadlift (Barbell)",
            "Deadlift (Dumbbell)",
            "Deadlift (Smith machine)",
            "Deadlift High Pull (Barbell)",
            "Decline Bench Press (Barbell)",
            "Decline Bench Press (Dumbbell)",
            "Decline Bench Press (Smith machine)",
            "Decline Crunch",
            "Deficit Deadlift (Barbell)",
            "Eliptical Machine",
            "Face Pull (Cable)",
            "Flat Knee Raise",
            "Flat Leg Raise",
            "Floor Press (Barbell)",
            "Front Raise (Band)",
            "Front Raise (Barbell)",
            "Front Raise (Cable)",
            "Front Raise (Dumbbell)",
            "Front Raise (Plate)",
            "Front Squat (Barbell)",
            "Glute Ham Raise",
            "Glute Kickback (Machine)",
            "Goblet Squat (Kettlebell)",
            "Goo Morning (Barbell)",
            "Hack Squat",
            "Hack Squat (Barbell)",
            "Hammer Curl (Band)",
            "Hammer Curl (Cable)",
            "Hammer Curl (Dumbbell)",
            "Handstand Push Up",
            "Hang Clean (Barbell)",
            "Hang Snatch (Barbell)",
            "Hanging Leg Raise",
            "Hanging Leg Raise",
            "High Knee Skips",
            "Hiking",
            "Hip Adductor (Machine)",
            "Hip Adductor (Barbell)",
            "Hip Thrust (Barbell)",
            "Hip Thrust (Bodyweight)",
            "Incline Bench Press (Barbell)",
            "Incline Bench Press (Cable)",
            "Incline Bench Press (Dumbbell)",
            "Incline Bench Press (Smith Machine)",
            "Incline Chest Press (Machine)",
            "Incline Curl (Dumbbell)",
            "Incline Row (Bodyweight)",
            "Iso-Lateral Chest Press (Machine)",
            "Iso-Lateral Row (Machine)",
            "Jackknife Sit Up",
            "Jump Rope",
            "Jump Shrug (Barbell)",
            "Jump Squat",
            "Jumping Jack",
            "Kettlebell Swing",
            "Kettlebell Turkish Get Up",
            "Kipping Pull Up",
            "Knee Raise (Captain's Chair)",
            "Kneeling Pulldown (Band)",
            "Knees to Elbows",
            "Lat Pulldown (Cable)",
            "Lat Pulldown (Machine)",
            "Lat Pulldown (Single Arm)",
            "Lat Pulldown - Underhand (Band)",
            "Lat Pulldown Underhand (Cable)",
            "Lat Pulldown - Wide Grip (Cable)",
            "Lateral Box Jump",
            "Lateral Raise (Cable)",
            "Lateral Raise (Dumbbell)",
            "Lateral Raise (Machine)",
            "Leg Extension (Machine)",
            "Leg Press",
            "Lunge (Barbell)",
            "Lunge (Bodyweight)",
            "Lunge (Dumbbell)",
            "Lying Leg Curl (Machine)",
            "Mountain CLimber",
            "Muscle Up",
            "Oblique Crunch",
            "Overhead Press (Barbell)",
            "Overhead Press (Cable)",
            "Overhead Press (Dumbbell)",
            "Overhead Press (Smith Machine)",
            "Overhead Squat (Barbell)",
            "Peck Deck (Machine)",
            "Pendlay Row (Barbell)",
            "Pistol Squat",
            "Plank",
            "Power Clean",
            "Power Snatch (Barbell)",
            "Preacher Curl (Barbell)",
            "Preacher Curl (Machine)",
            "Press under (Barbell)",
            "Pull Up",
            "Pull Up (Band)",
            "Pull Up (Assisted)",
            "Pullover (Machine)",
            "Push Up (Band)",
            "Push Up",
            "Push Up (Knees)",
            "Rock Pull (Barbell)",
            "Reverse Crunch",
            "Reverse Curl (Band)",
            "Reverse Curl (Barbell)",
            "Reverse Curl (Dumbbell)",
            "Reverse Fly (Cable)",
            "Reverse Fly (Dumbbell)",
            "Reverse Fly (Machine)",
            "Reverse Grip Concentration Curl",
            "Reverse Plank",
            "Romanian Deadlift (Barbell)",
            "Romanian Deadlift (Dumbbell)",
            "Rowing (Machine)",
            "Running",
            "Running (Treadmil)",
            "Russian Twist",
            "Seated Calf Raise (Machine)",
            "Seated Calf Raise (Plate Loaded)",
            "Seated Leg Curl (Machine)",
            "Seated Leg Press (Machine)",
            "Seated Overhead Press (Barbell)",
            "Seated Overhead Press (Dumbbell)",
            "Seated Palms Up Wrist Curl (Dumbbell)",
            "Seated Row (Cable)",
            "Seated Row (Machine)",
            "Seated Wide-Grip Row (Cable)",
            "Shoulder Press (Machine)",
            "Shoulder Press (Plate Loaded)",
            "Shrug (Barbell)",
            "Shrug (Machine)",
            "Shrug (Smith Machine)",
            "Side Bend (Band)",
            "Side Bend (Cable)",
            "Side Bend (Dumbbell)",
            "Side Plank",
            "Single Leg Bridge",
            "Sit Up",
            "Skating",
            "Skiing",
            "Skullcrusher (Barbell)",
            "Skullcrusher (Dumbbell)",
            "snatch (Barbell)",
            "Snatch Pull (Barbell)",
            "Snowboarding",
            "Split Jerk (Barbell)",
            "Squat (Band)",
            "Squat (Barbell)",
            "Squat (Bodyweight)",
            "Squat (Dumbbell)",
            "Squat (Machine)",
            "Squat (Smith Machine)",
            "Squat Row (Band)",
            "Standing Calf Raise (Barbell)",
            "Standing Calf Raise (Bodyweight)",
            "Standing Calf Raise (Dumbbell)",
            "Standing Calf Raise (Machine)",
            "Standing Calf Raise (Smith Machine)",
            "Step-up",
            "Stiff Leg Deadlift (Barbell)",
            "Stiff Leg Deadlift (Dumbbell)",
            "Straight Leg Deadlift (Band)",
            "Stretching",
            "Strict Military Press (Barbell)",
            "Sumo Deadlift (Barbell)",
            "Sumo Deadlift High Pull (Barbell)",
            "Superman",
            "Swimming",
            "T Bar Row",
            "Thruster (Barbell)",
            "Thruster (Kettlebell)",
            "Toes to Bar",
            "Torso Rotation (Machine)",
            "Trap Bar Deadlift",
            "Triceps Dip",
            "Tricpes Dip (Assisted)",
            "Triceps Extension",
            "Triceps Extension (Barbell)",
            "Triceps Extension (Cable)",
            "Triceps Extension (Machine)",
            "Triceps Pushdown",
            "Upright Row (Barbell)",
            "Upright Row (Cable)",
            "Upright Row (Dumbbell)",
            "V Up",
            "Vertical Bench Press",
            "Walking",
            "Wide Pull Up",
            "Wrist Roller",
            "Yoga",
            "Zercher Squat (Barbell)"
        ];

        foreach ($exercisesList as $exercise) {
            DB::table('exercises')->insert([
                'name' => $name = $exercise,
                'image' => str_slug($name) . '.png',
                'description' => "Description for ".$name,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
