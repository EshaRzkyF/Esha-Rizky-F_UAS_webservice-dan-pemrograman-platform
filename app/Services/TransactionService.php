<?php

namespace App\Services;

use App\Models\Transaction;
use App\Services\AiCategorizationService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class TransactionService
{
    public function __construct(protected AiCategorizationService $categorization)
    {
    }

    public function list() : Collection
    {
        return Transaction::where('user_id', Auth::id())
            ->orderByDesc('date')
            ->get();
    }

    public function find(int $id): ?Transaction
    {
        return Transaction::where('user_id', Auth::id())->find($id);
    }

    public function create(array $data): Transaction
    {
        $data['user_id'] = Auth::id();
        $data['category'] = $data['category'] ?? $this->categorization->categorize($data['description'] ?? '');

        return Transaction::create($data);
    }

    public function update(int $id, array $data): ?Transaction
    {
        $transaction = $this->find($id);

        if (! $transaction) {
            return null;
        }

        if (isset($data['description']) && ! isset($data['category'])) {
            $data['category'] = $this->categorization->categorize($data['description']);
        }

        $transaction->update($data);

        return $transaction;
    }

    public function delete(int $id): bool
    {
        $transaction = $this->find($id);

        return $transaction ? $transaction->delete() : false;
    }
}
