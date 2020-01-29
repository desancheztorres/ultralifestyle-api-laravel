<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\WorkoutHistory;
use App\Transformers\WorkoutHistoryTransformer;
use App\Http\Requests\WorkoutHistory\StoreWorkoutHistoryRequest;
use DB;
use Illuminate\Support\Carbon;

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
                'created_at'    => Carbon::now(),
            ];
        }


        $workout::insert($sets);

        return response()->json([
            'data' => [
                $sets
            ]
        ], 200);
    }

    public function showByDate($date) {

        $dateFormat = \Carbon\Carbon::parse($date)->format('Y-m-d');

        $user_id = $userId = Auth::guard('api')->id();

        $workouts = WorkoutHistory::
            whereBetween('created_at', array($dateFormat.' 00:00:00', $dateFormat.' 23:59:59'))
                ->where('user_id', $user_id)
                ->get()
                ->groupBy(function($date) {
                    return Carbon::parse($date->created_at)->format('d-m-Y');
                });

        return response()->json([
            'data' => $workouts
        ], 200);
    }
}
