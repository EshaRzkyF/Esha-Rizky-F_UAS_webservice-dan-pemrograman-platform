<?php

namespace App\Services;

use App\Models\Plan;
use Illuminate\Support\Facades\Auth;

class PlanningService
{
    public function __construct(protected AnalysisService $analysis)
    {
    }

    public function generate(): Plan
    {
        $report = $this->analysis->latest();

        $balance = $report?->balance ?? 0;
        $savingTarget = round($balance * 0.3, 2);

        return Plan::create([
            'user_id' => Auth::id(),
            'saving_target' => $savingTarget,
            'balance' => $balance,
            'generated_at' => now(),
        ]);
    }

    public function latest()
    {
        return Plan::where('user_id', Auth::id())
            ->latest('generated_at')
            ->first();
    }
}
