<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Routine};
use Auth;
use App\Http\Requests\Workout\UpdateWorkoutRequest;

class WorkoutController extends Controller
{
    public function index() {
        $userId = Auth::guard('api')->id();

        $routine = Routine::where('user_id', $userId)->first();

        $exercises = [];

        foreach ($routine->exercises as $exercise) {
            array_push($exercises, $exercise);
        }

        return response()->json([
            'data' => $exercises
        ], 200);
    }

    public function show($id) {
        $userId = Auth::guard('api')->id();

        $routine = Routine::where('user_id', $userId)->firstOrFail();

        $workout = null;

        foreach ($routine->exercises as $exercise) {
            if($exercise->pivot->exercise_id == $id) {
                $workout = $exercise;
            }
        }

        return response()->json([
            'data' => $workout
        ], 200);
    }

    public function showDaily($day) {
        $userId = Auth::guard('api')->id();

        $routine = Routine::where('user_id', $userId)->firstOrFail();

        $workouts = array();

        foreach ($routine->exercises as $exercise) {
            if($exercise->pivot->week_day_id == $day) {
                array_push($workouts, $exercise);
            }
        }

        return response()->json([
            'data' => $workouts
        ], 200);

    }

    public function start($day) {
        $userId = Auth::guard('api')->id();

        $routine = Routine::where('user_id', $userId)->firstOrFail();

        $workout = $routine->exercises()
            ->where('week_day_id', $day)
            ->where('completed', 0)
            ->orderByDesc('exercise_routine.created_at')
            ->first();

        return response()->json([
            'data' => $workout
        ], 200);
    }

    public function update($day, $exercise, UpdateWorkoutRequest $request) {
        
        $sets = $request->get('sets');
        $reps = $request->get('reps');
        $kg = $request->get('kg');
        $completed = $request->get('completed');
        $time = $request->get('time');

        $userId = Auth::guard('api')->id();

        $routine = Routine::where('user_id', $userId)->firstOrFail();

        $routine->exercises()
            ->where('week_day_id', $day)
            ->where('completed', 0)
            ->where('exercise_id', $exercise)
            ->update([
                'sets' => $sets,
                'reps' => $reps,
                'kg' => $kg,
                'time' => $time,
                'completed' => $completed,
            ]);

        $workout = $routine->exercises()
            ->where('week_day_id', $day)
            ->where('completed', 0)
            ->where('exercise_id', $exercise)
            ->first();

        return response()->json([
            'data' => $workout
        ], 200);
    }
}
