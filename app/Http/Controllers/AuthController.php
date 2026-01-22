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

        if (! $token = Auth::guard('api')->attempt($credentials)) {  //attempt is a method that checks if the credentials are valid
            return response()->json([ //response is a method that returns a JSON response
                'error' => 'Invalid credentials' 
            ], 401);
        }

        return response()->json([
            'token' => $token  //token is a string that is used to authenticate the user
        ]);
    }

    // AUTHENTICATED USER
    public function me()
    { //me is a method that returns the authenticated user
        return response()->json(
            Auth::guard('api')->user() 
        );
    }

    // LOGOUT
    public function logout()
    {
        Auth::guard('api')->logout(); //logout is a method that logs out the user

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}