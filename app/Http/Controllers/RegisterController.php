<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;
use App\Transformers\UserTransformer;

class RegisterController extends Controller
{
    public function register(StoreUserRequest $request) {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();

        return $user;
    }
}
