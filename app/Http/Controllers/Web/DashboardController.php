<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    public function index(){
        $userId = Auth::id();
        //fetches the logged-in user
        $balance = Account::where('user_id', $userId)->sum('balance');  //add up account balance
        $income = Transaction::where('amount', '>', 0)->sum('amount'); //feches the transactions the amount is positive
        $expense = abs(Transaction::where('amount', '<', 0)->sum('amount')); //fetches transactions where amount is negative convert to positive using abs()

        return view('dashboard', compact('balance', 'income', 'expense'));
    }
}
