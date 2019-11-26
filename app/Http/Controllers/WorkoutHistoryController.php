<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\WorkoutHistory;
use App\Transformers\WorkoutHistoryTransformer;
use App\Http\Requests\WorkoutHistory\StoreWorkoutHistoryRequest;
use Illuminate\Http\Request;
use DB;

class WorkoutHistoryController extends Controller
{
    public function index() {
        $userId = Auth::guard('api')->id();
        $workouts = WorkoutHistory::where('user_id', $userId)->get();

        return fractal()
            ->collection($workouts)
            ->transformWith(new WorkoutHistoryTransformer)
            ->toArray();
    }

    public function store(StoreWorkoutHistoryRequest $request) {


        $workout = new WorkoutHistory;
        $sets = [];

        for($i=0; $i<count($request->sets); $i++) {
            $sets[] = [
                'exercise_id'   => $request->exercise_id,
                'set'           => $request->sets[$i]['set'],
                'reps'          => $request->sets[$i]['reps'],
                'kg'            => $request->sets[$i]['kg'],
                'time'          => $request->sets[$i]['time'],
                'user_id'       => $request->user()->id,
            ];
        }


        $workout::insert($sets);

        return response()->json([
            'data' => [
                $sets
            ]
        ], 200);
    }
}
