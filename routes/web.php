<?php

use App\Http\Controllers\Web\AnalysisController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\GoalController;
use App\Http\Controllers\Web\PlanningController;
use App\Http\Controllers\Web\TransactionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.perform');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('web.transactions.store');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::post('/categories', [CategoryController::class, 'store'])->name('web.categories.store');
    Route::get('/goals', [GoalController::class, 'index'])->name('goals');
    Route::post('/goals', [GoalController::class, 'store'])->name('web.goals.store');
    Route::get('/planning', [PlanningController::class, 'index'])->name('planning');
    Route::get('/analysis/summary', [AnalysisController::class, 'summary'])->name('analysis.summary');
    Route::get('/analysis/insights', [AnalysisController::class, 'insights'])->name('analysis.insights');
    Route::post('/analysis/generate', [AnalysisController::class, 'generate'])->name('analysis.generate');
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
});
