<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AnalysisService;
use Illuminate\Http\JsonResponse;

class AnalysisController extends Controller
{
    public function __construct(protected AnalysisService $service)
    {
    }

    public function analyze(): JsonResponse
    {
        $report = $this->service->calculate();

        return response()->json($report->load('breakdowns'));
    }

    public function latest(): JsonResponse
    {
        $report = $this->service->latest();

        return response()->json($report ? $report->load('breakdowns') : null);
    }
}
