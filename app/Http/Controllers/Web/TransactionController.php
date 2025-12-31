<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display all transactions for the authenticated user
     */
    public function index()
    {
        $userId = Auth::id();
        
        // Get transactions with account and category relationships
        $transactions = Transaction::whereHas('account', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->with(['account', 'category'])
        ->latest('date')
        ->paginate(20);

        return view('transactions', compact('transactions'));
    }

    /**
     * Show the form for creating a new transaction
     */
    public function create()
    {
        $userId = Auth::id();
        $accounts = Account::where('user_id', $userId)->get();
        $categories = Category::all();
        
        return view('transactions-create', compact('accounts', 'categories'));
    }

    /**
     * Store a newly created transaction
     */
    public function store(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $userId = Auth::id();

        // Security check: account belongs to user
        $account = Account::where('id', $request->account_id)
                          ->where('user_id', $userId)
                          ->firstOrFail();

        // Create transaction
        $transaction = Transaction::create([
            'account_id' => $account->id,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'amount' => $request->amount,
            'date' => $request->date
        ]);

        // Update account balance
        $account->balance += $request->amount;
        $account->save();

        return redirect('/transactions')->with('success', 'Transaction added successfully');
    }
}
