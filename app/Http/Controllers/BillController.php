<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    // List all bills
    public function index()
    {
        return Bill::where('user_id', Auth::id())
                   ->orderBy('due_date')
                   ->get();
    }

    // Store a new bill
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'due_date' => 'required|date'
        ]);

        $bill = Bill::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'amount' => $request->amount,
            'due_date' => $request->due_date
        ]);

        return response()->json([
            'message' => 'Bill added successfully',
            'bill' => $bill
        ], 201);
    }
}
