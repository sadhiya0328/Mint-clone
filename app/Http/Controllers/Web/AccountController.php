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
        $accounts = Account::where('user_id', Auth::id())->get();
        return view('accounts', compact('accounts'));
    }

    public function store(Request $request)
    {
        Account::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'type' => $request->type,
            'balance' => $request->balance,
        ]);

        return redirect('/accounts');
    }
}
