<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    // Get all accounts of logged-in user
    public function index()
    {
        $accounts = Auth::user()->accounts;
        return response()->json($accounts);
    }

    // Create a new account
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'balance' => 'required|numeric'
        ]);

        $account = Account::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'type' => $request->type,
            'balance' => $request->balance,
            'plaid_item_id' => null // later for Plaid
        ]);

        return response()->json([
            'message' => 'Account created successfully',
            'account' => $account
        ], 201);
    }

    // Show single account
    public function show(Account $account)
    {
        // Security check
        if ($account->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($account);
    }

    // Update account
    public function update(Request $request, Account $account)
    {
        if ($account->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $account->update($request->only(['name', 'type', 'balance']));

        return response()->json([
            'message' => 'Account updated',
            'account' => $account
        ]);
    }

    // Delete account
    public function destroy(Account $account)
    {
        if ($account->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $account->delete();

        return response()->json([
            'message' => 'Account deleted'
        ]);
    }
}
