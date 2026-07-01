<?php

use App\Http\Controllers\Api\AnalysisController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GoalController;
use App\Http\Controllers\Api\PlanningController;
use App\Http\Controllers\Api\SummaryController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('transactions', TransactionController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::apiResource('goals', GoalController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::post('/analyze', [AnalysisController::class, 'analyze']);
    Route::get('/analyze/latest', [AnalysisController::class, 'latest']);

    Route::post('/plans', [PlanningController::class, 'store']);
    Route::get('/plans/latest', [PlanningController::class, 'latest']);

    Route::get('/finance/summary', [SummaryController::class, 'index']);
});
