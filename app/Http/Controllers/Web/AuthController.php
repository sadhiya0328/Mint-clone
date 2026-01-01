<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function showRegister(){
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('auth.register');
    }
    public function register(Request $request){
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        // Validation with custom messages
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ], [
            'name.required' => 'All required fields must be filled',
            'email.required' => 'All required fields must be filled',
            'email.email' => 'Invalid email',
            'email.unique' => 'Email already exists',
            'password.required' => 'All required fields must be filled',
            'password.min' => 'Password must be at least 6 characters',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect('/login');
    }
    public function showLogin(){
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('auth.login');
    }
    public function login(Request $request){
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        // Validation with custom messages
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'All required fields must be filled',
            'email.email' => 'Invalid email',
            'password.required' => 'All required fields must be filled',
        ]);

        $credentials = $request->only('email', 'password');
        
        if(Auth::attempt($credentials)){
            return redirect('/dashboard');
        }
        
        // Check if user exists
        $user = User::where('email', $request->email)->first();
        
        if($user){
            // User exists but password is wrong
            return back()->withErrors([
                'password' => 'Incorrect password',
            ])->withInput($request->only('email'));
        } else {
            // User doesn't exist - show error on email field
            return back()->withErrors([
                'email' => 'Invalid email',
            ])->withInput($request->only('email'));
        }
    }
    public function logout(){
        Auth::logout();
        return redirect('/register');
    }
}
