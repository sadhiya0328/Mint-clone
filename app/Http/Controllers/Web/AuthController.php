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
        return view('auth.register');
    }
    public function register(Request $request){
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect('/login');
    }
    public function showLogin(){
        return view('auth.login');
    }
    public function login(Request $request){
        if(Auth::attempt($request->only('email', 'password'))){
            return redirect('/dashboard');
        }
        return back();
    }
    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
