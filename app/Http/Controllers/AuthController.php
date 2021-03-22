<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        return response()->json('user created');
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            return response()->json(['message' => 'Bad credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        $validityDate = 86400;
        return response()->json(['message' => 'Welcome ' . $user->username])->withCookie(cookie('token_bearer', $token, $validityDate, null, null, false, false));
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json(['status' => 200]);
    }

    public function whoami()
    {
        return UserResource::make(Auth::user());
    }
}
