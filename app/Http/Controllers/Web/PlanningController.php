<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AiInsight;
use App\Services\PlanningService;

class PlanningController extends Controller
{
    public function __construct(protected PlanningService $service)
    {
    }

    public function index()
    {
        $plan = $this->service->latest();

        if (! $plan) {
            $plan = $this->service->generate();
        }

        $goals = auth()->user()->goals()->orderBy('deadline')->get();
        $insight = AiInsight::where('user_id', auth()->id())->latest('created_at')->first();

        return view('planning', compact('plan', 'goals', 'insight'));
    }
}
