<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // POST /api/v1/login
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Email atau password salah.'], 401);
        }

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'data' => [
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => ['name' => $user->name, 'email' => $user->email],
            ],
        ]);
    }

    // POST /api/v1/logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout berhasil.']);
    }

    // GET /api/v1/me
    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'data' => ['name' => $user->name, 'email' => $user->email],
        ]);
    }
}