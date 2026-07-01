<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Goal;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SummaryController extends Controller
{
    public function index(): JsonResponse
    {
        $user = Auth::user();

        $totalIncome = $user->transactions()->where('type', 'income')->sum('amount');
        $totalExpense = $user->transactions()->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;
        $goalCount = $user->goals()->count();

        return response()->json([
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'balance' => $balance,
            'goal_count' => $goalCount,
        ]);
    }
}
