<?php

namespace App\Services;

use App\Models\Goal;
use Illuminate\Support\Facades\Auth;

class GoalService
{
    public function list()
    {
        return Goal::where('user_id', Auth::id())->orderBy('deadline')->get();
    }

    public function create(array $data): Goal
    {
        return Goal::create(array_merge($data, ['user_id' => Auth::id()]));
    }

    public function find(int $id): ?Goal
    {
        return Goal::where('user_id', Auth::id())->find($id);
    }

    public function update(int $id, array $data): ?Goal
    {
        $goal = $this->find($id);

        if (! $goal) {
            return null;
        }

        $goal->update($data);

        return $goal;
    }

    public function delete(int $id): bool
    {
        $goal = $this->find($id);

        return $goal ? $goal->delete() : false;
    }
}
