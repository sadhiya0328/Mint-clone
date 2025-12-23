<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // REGISTER
    public function register(Request $request)
    {
        // Validation
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        // Create user
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Response
        return response()->json([
            'message' => 'User registered successfully'
        ]);
    }

    // LOGIN (JWT TOKEN)
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'error' => 'Invalid credentials'
            ], 401);
        }

        return response()->json([
            'token' => $token
        ]);
    }

    // AUTHENTICATED USER
    public function me()
    {
        return response()->json(
            Auth::guard('api')->user()
        );
    }

    // LOGOUT
    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}