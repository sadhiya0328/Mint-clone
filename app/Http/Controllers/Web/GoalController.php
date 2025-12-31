<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Goal;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    /**
     * Display all goals for the authenticated user
     */
    public function index()
    {
        $userId = Auth::id();

        $goals = Goal::where('user_id', $userId)
            ->latest()
            ->get()
            ->map(function ($goal) {
                $percentage = $goal->target_amount > 0 
                    ? min(100, ($goal->current_amount / $goal->target_amount) * 100) 
                    : 0;
                
                return [
                    'goal' => $goal,
                    'percentage' => $percentage,
                    'remaining' => max(0, $goal->target_amount - $goal->current_amount)
                ];
            });

        return view('goals', compact('goals'));
    }

    /**
     * Show the form for creating a new goal
     */
    public function create()
    {
        return view('goals-create');
    }

    /**
     * Store a newly created goal
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'target_amount' => 'required|numeric|min:1',
            'current_amount' => 'nullable|numeric|min:0'
        ]);

        Goal::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'target_amount' => $request->target_amount,
            'current_amount' => $request->current_amount ?? 0
        ]);

        return redirect('/goals')->with('success', 'Goal created successfully');
    }

    /**
     * Update goal progress
     */
    public function update(Request $request, Goal $goal)
    {
        if ($goal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'current_amount' => 'required|numeric|min:0'
        ]);

        $goal->update([
            'current_amount' => $request->current_amount
        ]);

        return redirect('/goals')->with('success', 'Goal updated successfully');
    }
}


