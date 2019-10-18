<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ethnic;
use App\Transformers\EthnicTransformer;
use App\Http\Requests\{StoreEthnicRequest, UpdateEthnicRequest};


class EthnicController extends Controller
{
    public function index() {
        $ethnics = Ethnic::all();

        return fractal()
            ->collection($ethnics)
            ->transformWith(new EthnicTransformer)
            ->toArray();
    }

    public function show(Ethnic $ethnic) {
        return fractal()
            ->item($ethnic)
            ->transformWith(new EthnicTransformer)
            ->toArray();
    }

    public function store(StoreEthnicRequest $request) {
        $ethnic = new Ethnic;

        $ethnic->name = $request->name;
        $ethnic->save();

        return fractal()
            ->item($ethnic)
            ->transformWith(new EthnicTransformer)
            ->toArray();
    }

    public function update(UpdateEthnicRequest $request, Ethnic $ethnic) {

        $ethnic->name = $request->get('name', $ethnic->name);
        $ethnic->save();

        return fractal()
            ->item($ethnic)
            ->transformWith(new EthnicTransformer)
            ->toArray();
    }

    public function destroy(Ethnic $ethnic) {
        $ethnic->delete();

        return response(null, 204);
    }
}
