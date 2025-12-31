<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BillController extends Controller
{
    /**
     * Display all bills for the authenticated user
     */
    public function index()
    {
        $userId = Auth::id();

        $bills = Bill::where('user_id', $userId)
            ->orderBy('due_date')
            ->get()
            ->map(function ($bill) {
                $dueDate = Carbon::parse($bill->due_date);
                $today = Carbon::today();
                $daysUntilDue = $today->diffInDays($dueDate, false);

                return [
                    'bill' => $bill,
                    'days_until_due' => $daysUntilDue,
                    'is_overdue' => $dueDate->isPast(),
                    'is_due_soon' => $daysUntilDue >= 0 && $daysUntilDue <= 7
                ];
            });

        return view('bills', compact('bills'));
    }

    /**
     * Show the form for creating a new bill
     */
    public function create()
    {
        return view('bills-create');
    }

    /**
     * Store a newly created bill
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'due_date' => 'required|date'
        ]);

        Bill::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'amount' => $request->amount,
            'due_date' => $request->due_date
        ]);

        return redirect('/bills')->with('success', 'Bill added successfully');
    }
}


