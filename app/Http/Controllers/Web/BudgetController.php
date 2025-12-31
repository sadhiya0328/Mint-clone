<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    /**
     * Display all budgets for the authenticated user
     */
    public function index()
    {
        $userId = Auth::id();

        $budgets = Budget::where('user_id', $userId)
            ->with('category')
            ->get();

        // Calculate spent amounts for each budget
        $budgetsWithSpent = $budgets->map(function ($budget) use ($userId) {
            $spent = Transaction::whereHas('account', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })
                ->where('amount', '<', 0) // Only expenses
                ->when($budget->category_id, function ($q) use ($budget) {
                    $q->where('category_id', $budget->category_id);
                })
                ->sum('amount');

            return [
                'budget' => $budget,
                'spent' => abs($spent),
                'remaining' => $budget->amount - abs($spent),
                'percentage' => $budget->amount > 0 ? min(100, (abs($spent) / $budget->amount) * 100) : 0
            ];
        });

        return view('budgets', compact('budgetsWithSpent'));
    }

    /**
     * Show the form for creating a new budget
     */
    public function create()
    {
        $categories = Category::all();
        return view('budgets-create', compact('categories'));
    }

    /**
     * Store a newly created budget
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        Budget::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'amount' => $request->amount
        ]);

        return redirect('/budgets')->with('success', 'Budget created successfully');
    }
}


