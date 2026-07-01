<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGoalRequest;
use App\Http\Requests\UpdateGoalRequest;
use App\Models\Goal;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Auth::user()->goals()->orderBy('deadline')->get());
    }

    public function store(StoreGoalRequest $request): JsonResponse
    {
        $goal = Goal::create(array_merge($request->validated(), ['user_id' => Auth::id()]));

        return response()->json($goal);
    }

    public function update(UpdateGoalRequest $request, int $id): JsonResponse
    {
        $goal = Auth::user()->goals()->find($id);

        if (! $goal) {
            return response()->json(['message' => 'Goal not found'], 404);
        }

        $goal->update($request->validated());

        return response()->json($goal);
    }

    public function destroy(int $id): JsonResponse
    {
        $goal = Auth::user()->goals()->find($id);

        if (! $goal) {
            return response()->json(['message' => 'Goal not found'], 404);
        }

        $goal->delete();

        return response()->json(['message' => 'Goal deleted']);
    }
}
