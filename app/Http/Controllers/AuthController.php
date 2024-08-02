<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $cr = $request->only('email', 'password');

        if (!Auth::attempt($cr)) {
            $user = User::where('email', $request->email)->first();
            $errorMessage = $user ? 'password wrong' : 'email not registered';
            return response()->json([
                "message" => $errorMessage
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            "status" => true,
            "token" => $token,
            "type" => "Bearer"
        ], 200);
    }
}
