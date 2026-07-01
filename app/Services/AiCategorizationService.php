<?php

namespace App\Services;

class AiCategorizationService
{
    protected array $rules = [
        'makan' => 'food',
        'nasi' => 'food',
        'bensin' => 'transport',
        'tol' => 'transport',
        'gaji' => 'income',
        'listrik' => 'utilities',
        'air' => 'utilities',
        'internet' => 'utilities',
        'belanja' => 'shopping',
    ];

    public function categorize(string $description): string
    {
        $description = strtolower($description);

        foreach ($this->rules as $keyword => $category) {
            if (str_contains($description, $keyword)) {
                return $category;
            }
        }

        return 'other';
    }
}
