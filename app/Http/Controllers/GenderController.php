<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gender;
use App\Transformers\GenderTransformer;
use App\Http\Requests\{StoreGenderRequest, UpdateGenderRequest};

class GenderController extends Controller
{
    public function index() {
        $genders = Gender::all();

        return fractal()
            ->collection($genders)
            ->transformWith(new GenderTransformer)
            ->toArray();
    }

    public function show(Gender $gender) {
        return fractal()
            ->item($gender)
            ->transformWith(new GenderTransformer)
            ->toArray();
    }

    public function store(StoreGenderRequest $request) {
        $gender = new Gender;
        $gender->name = $request->name;
        $gender->save();

        return fractal()
            ->item($gender)
            ->transformWith(new GenderTransformer)
            ->toArray();
    }

    public function update(UpdateGenderRequest $request, Gender $gender) {
        $gender->name = $request->get('name', $gender->name);
        $gender->save();

        return fractal()
            ->item($gender)
            ->transformWith(new GenderTransformer)
            ->toArray();
    }

    public function destroy(Gender $gender) {
        $gender->delete();

        return response(null, 204);
    }
}
