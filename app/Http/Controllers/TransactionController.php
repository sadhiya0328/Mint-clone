<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // Get all transactions of logged-in user
    public function index()
    {
        $transactions = Transaction::whereHas('account', function ($query) {
            $query->where('user_id', Auth::id());
        })->latest()->get();

        return response()->json($transactions);
    }

    // Store a new transaction
    public function store(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'description' => 'required|string',
            'type' => 'nullable|in:income,expense',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'category_id' => 'nullable'
        ]);

        // Security check: account belongs to user
        $account = Account::where('id', $request->account_id)
                          ->where('user_id', Auth::id())
                          ->firstOrFail();

        // Handle amount conversion based on type
        // If type is provided, use it; otherwise, infer from amount sign (backward compatibility)
        $amount = $request->amount;
        if ($request->has('type')) {
            if ($request->type === 'expense') {
                $amount = -abs($amount); // Ensure expense is negative
            } else {
                $amount = abs($amount); // Ensure income is positive
            }
        }
        // If type not provided, use amount as-is (backward compatibility for existing API calls)

        // Create transaction
        $transaction = Transaction::create([
            'account_id' => $account->id,
            'category_id' => $request->category_id, // can be null
            'description' => $request->description,
            'amount' => $amount,
            'date' => $request->date
        ]);

        // Update account balance
        $account->balance += $amount;
        $account->save();

        return response()->json([
            'message' => 'Transaction added successfully',
            'transaction' => $transaction
        ], 201);
    }
}
