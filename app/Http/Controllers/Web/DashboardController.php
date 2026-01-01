<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\Bill;
use App\Models\Budget;
use App\Models\Goal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with comprehensive financial overview
     */
    public function index()
    {
        $userId = Auth::id();

        // Account balance - sum of all user accounts
        $balance = Account::where('user_id', $userId)->sum('balance');

        // Income and Expense calculations (only from user's accounts)
        // Income: sum of all positive transaction amounts
        $income = Transaction::whereHas('account', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('amount', '>', 0)->sum('amount');

        // Total Expense: sum of ALL transaction amounts (all transactions are expenses)
        // Sum all transaction amounts as absolute values since all transactions represent money spent
        $expense = Transaction::whereHas('account', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->selectRaw('SUM(ABS(amount)) as total')->value('total') ?? 0;

        // Recent transactions (last 5)
        $recentTransactions = Transaction::whereHas('account', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->with(['account', 'category'])
        ->latest('date')
        ->limit(5)
        ->get();

        // Upcoming bills (all bills, sorted by due date)
        $upcomingBills = Bill::where('user_id', $userId)
            ->orderBy('due_date')
            ->limit(5)
            ->get()
            ->map(function ($bill) {
                $dueDate = Carbon::parse($bill->due_date);
                $today = Carbon::today();
                $daysUntilDue = $today->diffInDays($dueDate, false);
                $isOverdue = $dueDate->isPast();
                return [
                    'bill' => $bill,
                    'days_until_due' => $daysUntilDue,
                    'is_overdue' => $isOverdue
                ];
            });

        // Budget summaries
        $budgets = Budget::where('user_id', $userId)->with('category')->get();
        $budgetSummaries = $budgets->map(function ($budget) use ($userId) {
            // All transactions are expenses, so sum absolute values
            $spent = Transaction::whereHas('account', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })
                ->when($budget->category_id, function ($q) use ($budget) {
                    $q->where('category_id', $budget->category_id);
                })
                ->selectRaw('SUM(ABS(amount)) as total')->value('total') ?? 0;

            return [
                'budget' => $budget,
                'spent' => $spent,
                'percentage' => $budget->amount > 0 ? min(100, ($spent / $budget->amount) * 100) : 0
            ];
        })->take(3);

        // Goals summaries
        $goals = Goal::where('user_id', $userId)
            ->latest()
            ->limit(3)
            ->get()
            ->map(function ($goal) {
                $percentage = $goal->target_amount > 0 
                    ? min(100, ($goal->current_amount / $goal->target_amount) * 100) 
                    : 0;
                return [
                    'goal' => $goal,
                    'percentage' => $percentage
                ];
            });

        return view('dashboard', compact(
            'balance', 
            'income', 
            'expense',
            'recentTransactions',
            'upcomingBills',
            'budgetSummaries',
            'goals'
        ));
    }

    /**
     * Search across all dashboard content (bills, budgets, transactions, goals)
     */
    public function search(Request $request)
    {
        $userId = Auth::id();
        $query = $request->input('query', '');

        if (empty($query)) {
            return response()->json([
                'transactions' => [],
                'bills' => [],
                'budgets' => [],
                'goals' => []
            ]);
        }

        $searchTerm = '%' . $query . '%';

        // Search Transactions
        $transactions = Transaction::whereHas('account', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->where(function ($q) use ($searchTerm) {
            $q->where('description', 'LIKE', $searchTerm)
              ->orWhereHas('category', function ($catQ) use ($searchTerm) {
                  $catQ->where('name', 'LIKE', $searchTerm);
              })
              ->orWhereHas('account', function ($accQ) use ($searchTerm) {
                  $accQ->where('name', 'LIKE', $searchTerm);
              });
        })
        ->with(['account', 'category'])
        ->latest('date')
        ->limit(10)
        ->get()
        ->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'description' => $transaction->description,
                'amount' => $transaction->amount,
                'date' => $transaction->date->format('M d, Y'),
                'account' => $transaction->account->name,
                'category' => $transaction->category ? $transaction->category->name : null,
                'type' => 'transaction'
            ];
        });

        // Search Bills
        $bills = Bill::where('user_id', $userId)
            ->where('name', 'LIKE', $searchTerm)
            ->orderBy('due_date')
            ->limit(10)
            ->get()
            ->map(function ($bill) {
                return [
                    'id' => $bill->id,
                    'name' => $bill->name,
                    'amount' => $bill->amount,
                    'due_date' => $bill->due_date->format('M d, Y'),
                    'type' => 'bill'
                ];
            });

        // Search Budgets
        $budgets = Budget::where('user_id', $userId)
            ->where(function ($q) use ($searchTerm) {
                $q->whereHas('category', function ($catQ) use ($searchTerm) {
                    $catQ->where('name', 'LIKE', $searchTerm);
                });
            })
            ->with('category')
            ->limit(10)
            ->get()
            ->map(function ($budget) {
                return [
                    'id' => $budget->id,
                    'category' => $budget->category ? $budget->category->name : 'All Categories',
                    'amount' => $budget->amount,
                    'type' => 'budget'
                ];
            });

        // Search Goals
        $goals = Goal::where('user_id', $userId)
            ->where('name', 'LIKE', $searchTerm)
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($goal) {
                return [
                    'id' => $goal->id,
                    'name' => $goal->name,
                    'target_amount' => $goal->target_amount,
                    'current_amount' => $goal->current_amount,
                    'type' => 'goal'
                ];
            });

        return response()->json([
            'transactions' => $transactions,
            'bills' => $bills,
            'budgets' => $budgets,
            'goals' => $goals
        ]);
    }
}
