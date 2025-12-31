<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        if (!$userId) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $budgets = Budget::where('user_id', $userId)->get();

        $response = [];

        foreach ($budgets as $budget) {

            $spent = Transaction::whereHas('account', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })
                ->where('amount', '<', 0)
                ->when($budget->category_id, function ($q) use ($budget) {
                    $q->where('category_id', $budget->category_id);
                })
                ->sum('amount');

            $response[] = [
                'budget_id' => $budget->id,
                'user_id' => $budget->user_id,
                'category_id' => $budget->category_id,
                'budget_amount' => $budget->amount,
                'spent_amount' => abs($spent),
                'remaining_amount' => $budget->amount - abs($spent),
            ];
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'category_id' => 'nullable|integer'
        ]);

        $budget = Budget::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'amount' => $request->amount
        ]);

        return response()->json([

            'message' => 'Budget created successfully',
            'budget' => $budget
        ], 201);
    }
}
