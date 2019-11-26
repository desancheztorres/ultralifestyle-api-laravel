<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExperienceLevel;
use App\Http\Requests\ExperienceLevel\{StoreExperienceLevelRequest, UpdateExperienceLevelRequest};
use App\Transformers\ExperienceLevelTransformer;

class ExperienceLevelController extends Controller
{
    public function index() {
        $levels = ExperienceLevel::all();

        return fractal()
            ->collection($levels)
            ->transformWith(new ExperienceLevelTransformer)
            ->toArray();
    }

    public function show(ExperienceLevel $level) {
        return fractal()
            ->item($level)
            ->transformWith(new ExperienceLevelTransformer)
            ->toArray();
    }

    public function store(StoreExperienceLevelRequest $request) {
        $level = new ExperienceLevel;
        $level->name = $request->name;
        $level->slug = str_slug($request->name);
        $level->save();

        return fractal()
            ->item($level)
            ->transformWith(new ExperienceLevelTransformer)
            ->toArray();
    }

    public function update(UpdateExperienceLevelRequest $request, ExperienceLevel $level) {
        $level->name = $request->get('name', $level->name);
        $level->slug = str_slug($request->get('name', $level->name));
        $level->save();

        return fractal()
            ->item($level)
            ->transformWith(new ExperienceLevelTransformer)
            ->toArray();
    }

    public function destroy(ExperienceLevel $level) {
        $level->delete();

        return response(null, 204);
    }
}
