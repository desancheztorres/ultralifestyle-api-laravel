<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;
use App\Transformers\ExerciseTransformer;
use App\Http\Requests\StoreExerciseRequest;
use App\Http\Requests\UpdateExerciseRequest;

class ExerciseController extends Controller
{
    public function index() {
        $exercises = Exercise::latestFirst()->get();

        return fractal()
            ->collection($exercises)
            ->parseIncludes(['user', 'body_part'])
            ->transformWith(new ExerciseTransformer)
            ->toArray();

    }

    public function show(Exercise $exercise) {
        return fractal()
            ->item($exercise)
            ->parseIncludes(['body_part'])
            ->transformWith(new ExerciseTransformer)
            ->toArray();
    }

    public function store(StoreExerciseRequest $request) {
        $exercise = new Exercise;
        $exercise->name = $request->name;
        $exercise->image = $request->image;
        $exercise->description = $request->description;

        $exercise->save();
        
        $exercise->bodyParts()->sync($request->body_parts);

        return fractal()
            ->item($exercise)
            ->parseIncludes(['body_part'])
            ->transformWith(new ExerciseTransformer)
            ->toArray();
    }

    public function update(UpdateExerciseRequest $request, Exercise $exercise) {

        $exercise->name = $request->get('name', $exercise->name);
        $exercise->image = $request->get('image', $exercise->image);
        $exercise->description = $request->get('description', $exercise->description);
        $exercise->save();

        $exercise->bodyParts()->sync($request->body_parts);

        return fractal()
            ->item($exercise)
            ->parseIncludes(['body_part'])
            ->transformWith(new ExerciseTransformer)
            ->toArray();
    }

    public function destroy(Exercise $exercise) {
        $exercise->delete();

        return response(null, 204);
    }
}
