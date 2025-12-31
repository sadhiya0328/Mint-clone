<?php

use App\Http\Controllers\Web\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\AccountController;
use App\Http\Controllers\Web\TransactionController;
use App\Http\Controllers\Web\BudgetController;
use App\Http\Controllers\Web\BillController;
use App\Http\Controllers\Web\GoalController;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/accounts', [AccountController::class, 'index'])->middleware('auth');
Route::post('/accounts', [AccountController::class, 'store'])->middleware('auth');

// Transactions routes
Route::get('/transactions', [TransactionController::class, 'index'])->middleware('auth');
Route::get('/transactions/create', [TransactionController::class, 'create'])->middleware('auth');
Route::post('/transactions', [TransactionController::class, 'store'])->middleware('auth');

// Budgets routes
Route::get('/budgets', [BudgetController::class, 'index'])->middleware('auth');
Route::get('/budgets/create', [BudgetController::class, 'create'])->middleware('auth');
Route::post('/budgets', [BudgetController::class, 'store'])->middleware('auth');

// Bills routes
Route::get('/bills', [BillController::class, 'index'])->middleware('auth');
Route::get('/bills/create', [BillController::class, 'create'])->middleware('auth');
Route::post('/bills', [BillController::class, 'store'])->middleware('auth');

// Goals routes
Route::get('/goals', [GoalController::class, 'index'])->middleware('auth');
Route::get('/goals/create', [GoalController::class, 'create'])->middleware('auth');
Route::post('/goals', [GoalController::class, 'store'])->middleware('auth');
Route::put('/goals/{goal}', [GoalController::class, 'update'])->middleware('auth');



