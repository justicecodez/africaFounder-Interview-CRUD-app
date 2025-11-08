<?php

namespace App\Actions\Guest;

use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class User
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    public function create($data)
    {
        try {
            $user = ModelsUser::create($data);
            $token = $user->createToken('api-token')->plainTextToken;
            return ['user' => $user, 'token' => $token];
        } catch (\Throwable $th) {
            Log::error('User Registration Error: ' . $th->getMessage());
            return false;
        }
    }

    public function login($data)
    {
        try {
            $user = ModelsUser::where('email', $data['email'])->first();
            if (! $user || ! Hash::check($data['password'], $user->password)) {
                return response()->json([
                    'message' => 'The provided credentials are incorrect.'
                ], 401);
            }
            $token = $user->createToken('api-token')->plainTextToken;
            return ['user' => $user, 'token' => $token];
        } catch (\Throwable $th) {
            Log::error('User Login Error: ' . $th->getMessage());
            return false;
        }
    }
}
