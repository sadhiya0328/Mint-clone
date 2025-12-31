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
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'category_id' => 'nullable'
        ]);

        // Security check: account belongs to user
        $account = Account::where('id', $request->account_id)
                          ->where('user_id', Auth::id())
                          ->firstOrFail();

        // Create transaction
        $transaction = Transaction::create([
            'account_id' => $account->id,
            'category_id' => $request->category_id, // can be null
            'description' => $request->description,
            'amount' => $request->amount,
            'date' => $request->date
        ]);

        // Update account balance
        $account->balance += $request->amount;
        $account->save();

        return response()->json([
            'message' => 'Transaction added successfully',
            'transaction' => $transaction
        ], 201);
    }
}
