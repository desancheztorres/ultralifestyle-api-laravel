<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Transformers\UserTransformer;
use App\Http\Requests\UpdateUserRequest;
use Auth;

class UserController extends Controller
{
    public function index() {

        $users = User::latestFirst()->get();

        return fractal()
            ->collection($users)
            ->transformWith(new UserTransformer)
            ->toArray();
    }

    public function show(User $user) {
        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->toArray();
    }

    public function update(User $user, UpdateUserRequest $request) {
        $currentUserId = Auth::guard('api')->id();

        if($currentUserId != $user->id) {
            return response()->json([
                'data' => [
                    'error' => 'Unauthorized.'
                ]
            ], 403);
        }

        $user->name = $request->get('name', $request->name);
        $user->save();

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->toArray();

    }

    public function destroy(User $user) {
        $currentUserId = Auth::guard('api')->id();

        if($currentUserId != $user->id) {
            return response()->json([
                'data' => [
                    'error' => 'Unauthorized.'
                ]
            ], 403);
        }

        $user->delete();

        return response(null, 204);
    }
}
