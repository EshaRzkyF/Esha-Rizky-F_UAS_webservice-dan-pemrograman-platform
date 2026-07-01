<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    public function __construct(protected TransactionService $service)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json($this->service->list());
    }

    public function store(StoreTransactionRequest $request): JsonResponse
    {
        return response()->json($this->service->create($request->validated()));
    }

    public function update(UpdateTransactionRequest $request, int $id): JsonResponse
    {
        $transaction = $this->service->update($id, $request->validated());

        if (! $transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        return response()->json($transaction);
    }

    public function destroy(int $id): JsonResponse
    {
        if (! $this->service->delete($id)) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        return response()->json(['message' => 'Transaction deleted']);
    }
}
