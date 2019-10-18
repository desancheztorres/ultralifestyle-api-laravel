<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Target;
use App\Transformers\TargetTransformer;
use App\Http\Requests\{StoreTargetRequest, UpdateTargetRequest};

class TargetController extends Controller
{
    public function index() {
        $targets = Target::all();

        return fractal()
            ->collection($targets)
            ->TransformWith(new TargetTransformer)
            ->toArray();
    }

    public function show(Target $target) {
        return fractal()
            ->item($target)
            ->transformWith(new TargetTransformer)
            ->toArray();
    }

    public function store(StoreTargetRequest $request) {
        $target = new Target;

        $target->name = $request->name;
        $target->slug = str_slug($request->name);
        $target->type = $request->type;
        $target->save();

        return fractal()
            ->item($target)
            ->transformWith(new TargetTransformer)
            ->toArray();
    }

    public function update(UpdateTargetRequest $request, Target $target) {
        $target->name = $request->get('name', $target->name);
        $target->slug = str_slug($request->name);
        $target->type = $request->get('type', $target->type);
        $target->save();

        return fractal()
            ->item($target)
            ->transformWith(new TargetTransformer)
            ->toArray();
    }

    public function destroy(Target $target) {
        $target->delete();

        return response(null, 204);
    }
}
