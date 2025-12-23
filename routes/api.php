<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes , acceced by authenticated users jwt based token
Route::middleware('auth:api')->group(function () {
    Route::apiResource('accounts', AccountController::class);
    //apiResource single line It generates CRUD routes (Create, Read, Update, Delete)
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});