<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __invoke(Request $request) : JsonResponse
    {
        $token = null;

        $request->validate([
            'email' => 'required|string|max:255',
            'password' => 'required|string',
            "remember" => 'boolean'
        ]);

        $auth = Auth::attempt(
            $request->only('email', 'password' ),
            $request->input('remember')
        );

        if (!$auth) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        $token = $request->user()->createToken('auth_token')->plainTextToken;

        return response()->json(compact('token'));
    }
}
