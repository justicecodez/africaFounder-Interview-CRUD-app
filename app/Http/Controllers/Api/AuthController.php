<?php

namespace App\Http\Controllers\Api;

use App\Actions\Guest\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Guest\LoginFormRequest;
use App\Http\Requests\Guest\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginFormRequest $request, User $user)
    {
        $validated = $request->validated();
        // Login logic here
        $data =$user->login($validated);
        if ($data===false) {
            return response()->json(['message'=>'Login failed'], 500);
        }
        return response()->json($data, 200);
    }

    public function register(RegisterRequest $request, User $user)
    {
        $validated = $request->validated();
        $data=$user->create($validated);
        if ($data===false) {
            return response()->json(['message'=>'Registration failed'], 500);
        }
        return response()->json($data, 201);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message'=>'Logged out']);
    }
}
