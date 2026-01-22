<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    // ✅ THIS METHOD WAS MISSING
    public function index()
    {
        $accounts = Account::where('user_id', Auth::id())->get(); //gets all the accounts of the logged in user
        return view('accounts', compact('accounts')); //displays the accounts page
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'balance' => 'required|numeric'
        ]);

        Account::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'type' => $request->type,
            'balance' => $request->balance,
        ]);

        return redirect('/accounts')->with('success', 'Account created successfully!'); //redirects to the accounts page with a success message
    }

    // Delete account
    public function destroy(Account $account)
    {
        // Security check: account belongs to user
        if ($account->user_id !== Auth::id()) { //checks if the account belongs to the logged in user
            return redirect('/accounts')->with('error', 'Unauthorized');
        }

        $account->delete();

        return redirect('/accounts')->with('success', 'Account deleted successfully!');
    }
}
