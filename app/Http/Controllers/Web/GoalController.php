<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGoalRequest;
use App\Models\AiInsight;
use App\Services\GoalService;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    public function __construct(protected GoalService $service)
    {
    }

    public function index()
    {
        $goals = Auth::user()->goals()->orderBy('deadline')->get();
        $insight = AiInsight::where('user_id', Auth::id())->latest('created_at')->first();

        return view('goals', compact('goals', 'insight'));
    }

    public function store(StoreGoalRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()->route('goals')->with('status', 'Goal created successfully.');
    }
}
