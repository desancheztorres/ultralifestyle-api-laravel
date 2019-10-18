<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Weight;
use App\Http\Requests\StoreWeightRequest;
use App\Transformers\WeightTransformer;
use Auth;

class WeightController extends Controller
{
    public function index() {

        $userId = Auth::guard('api')->id();

        $weights = Weight::where('user_id', $userId)->get();
        
        return fractal()
            ->collection($weights)
            ->transformWith(new WeightTransformer)
            ->toArray();
    }

    public function store(StoreWeightRequest $request) {
       $weight = new Weight;

       $weight->weight = $request->get('weight');
       $weight->user()->associate($request->user());

       $weight->save();

        return fractal()
            ->item($weight)
            ->transformWith(new WeightTransformer)
            ->toArray();
    }
}
