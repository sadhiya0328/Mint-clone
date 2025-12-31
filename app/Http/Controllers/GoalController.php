<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    // List all goals
    public function index()
    {
        return Goal::where('user_id', Auth::id())->get();
    }

    // Create a new goal
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'target_amount' => 'required|numeric|min:1',
            'current_amount' => 'nullable|numeric|min:0'
        ]);

        $goal = Goal::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'target_amount' => $request->target_amount,
            'current_amount' => $request->current_amount ?? 0
        ]);

        return response()->json([
            'message' => 'Goal created successfully',
            'goal' => $goal
        ], 201);
    }

    // Update goal progress
    public function update(Request $request, Goal $goal)
    {
        if ($goal->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'current_amount' => 'required|numeric|min:0'
        ]);

        $goal->update([
            'current_amount' => $request->current_amount
        ]);

        return response()->json([
            'message' => 'Goal updated successfully',
            'goal' => $goal
        ]);
    }
}
