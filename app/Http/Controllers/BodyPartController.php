<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BodyPart;
use App\Transformers\BodyPartTransformer;
use App\Http\Requests\{StoreBodyPartRequest, UpdateBodyPartRequest};

class BodyPartController extends Controller
{
    public function index() {
        $bodyParts = BodyPart::alphabeticalOrder()->get();

        return fractal()
            ->collection($bodyParts)
            ->transformWith(new BodyPartTransformer)
            ->toArray();
    }

    public function show(BodyPart $bodyPart) {
        return fractal()
            ->item($bodyPart)
            ->transformWith(new BodyPartTransformer)
            ->toArray();
    }

    public function store(StoreBodyPartRequest $request) {
        $bodyPart = new BodyPart();

        $bodyPart->name = $request->name;
        $bodyPart->image = $request->image;
        $bodyPart->save();

        return fractal()
            ->item($bodyPart)
            ->transformWith(new BodyPartTransformer)
            ->toArray();
    }

    public function update(UpdateBodyPartRequest $request, BodyPart $bodyPart) {
        $bodyPart->name = $request->get('name', $bodyPart->name);
        $bodyPart->image = $request->get('image', $bodyPart->image);
        $bodyPart->save();

        return fractal()
            ->item($bodyPart)
            ->transformWith(new BodyPartTransformer)
            ->toArray();
    }

    public function destroy(BodyPart $bodyPart) {
        $bodyPart->delete();

        return response(null, 204);
    }
}
