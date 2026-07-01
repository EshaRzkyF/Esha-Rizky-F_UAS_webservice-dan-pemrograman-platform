<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PlanningService;
use Illuminate\Http\JsonResponse;

class PlanningController extends Controller
{
    public function __construct(protected PlanningService $service)
    {
    }

    public function store(): JsonResponse
    {
        return response()->json($this->service->generate());
    }

    public function latest(): JsonResponse
    {
        return response()->json($this->service->latest());
    }
}
