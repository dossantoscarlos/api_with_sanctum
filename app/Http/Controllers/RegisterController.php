<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __invoke(Request $request) {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            "remember" => 'boolean'
        ]);

        $user = new User;

        $user->query()->firstOrCreate($request->all());

        $auth = new AuthController;

        $result = $auth->__invoke($request);

        $token = $result->original['token'];

        return response()->json(compact('token'));
    }
}
