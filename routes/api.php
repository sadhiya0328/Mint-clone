<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\GoalController;
// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes , acceced by authenticated users jwt based token
Route::middleware('auth:api')->group(function () {
    Route::apiResource('accounts', AccountController::class);
    //apiResource single line It generates CRUD routes (Create, Read, Update, Delete)
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::get('/budgets', [BudgetController::class, 'store']);
    Route::post('/budgets', [BudgetController::class, 'index']);
    Route::post('/bills', [BillController::class, 'store']);
    Route::get('/bills', [BillController::class, 'index']);
    Route::post('/goals', [GoalController::class, 'store']);
    Route::get('/goals', [GoalController::class, 'index']);
    Route::put('/goals/{goal}', [GoalController::class, 'update']);
    
});