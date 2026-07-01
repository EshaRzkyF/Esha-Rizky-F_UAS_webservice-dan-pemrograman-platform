<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct(protected TransactionService $service)
    {
    }

    public function index(Request $request)
    {
        $query = Auth::user()->transactions()->orderByDesc('date');

        if ($request->filled('date')) {
            $query->whereDate('date', $request->input('date'));
        }

        if ($request->filled('category') && $request->input('category') !== 'all') {
            $query->where('category', $request->input('category'));
        }

        $transactions = $query->get();
        $categories = Auth::user()->transactions()->pluck('category')->unique()->filter()->sort()->values();

        return view('transactions', compact('transactions', 'categories'));
    }

    public function store(StoreTransactionRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()->route('transactions')->with('status', 'Transaction created successfully.');
    }
}
