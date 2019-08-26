<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Routine;
use App\Transformers\RoutineTransformer;
use App\Http\Requests\StoreRoutineRequest;
use App\Http\Requests\UpdateRoutineRequest;

class RoutineController extends Controller
{
    public function index() {
        $routines = Routine::latestFirst()->get();

        return fractal()
            ->collection($routines)
            ->parseIncludes(['user', 'exercises'])
            ->transformWith(new RoutineTransformer)
            ->toArray();
    }

    public function show(Routine $routine) {

        $this->authorize('show', $routine);

        return fractal()
            ->item($routine)
            ->parseIncludes(['user', 'exercises'])
            ->transformWith(new RoutineTransformer)
            ->toArray();
    }

    public function store(StoreRoutineRequest $request) {

        $routine = new Routine;
        $routine->name = $request->name;
        $routine->description = $request->description;
        $routine->user()->associate($request->user());

        $routine->save();

        return fractal()
            ->item($routine)
            ->parseIncludes(['user', 'exercises'])
            ->transformWith(new RoutineTransformer)
            ->toArray();
    }

    public function update(UpdateRoutineRequest $request, Routine $routine) {
        $this->authorize('update', $routine);
        $routine->name = $request->get('name', $routine->name);
        $routine->description = $request->get('description', $routine->description);
        $routine->save();

        return fractal()
            ->item($routine)
            ->parseIncludes(['user', 'exercises'])
            ->transformWith(new RoutineTransformer)
            ->toArray();
    }

    public function destroy(Routine $routine) {
        $this->authorize('destroy', $routine);

        $routine->delete();

        return response(null, 204);
    }
}
