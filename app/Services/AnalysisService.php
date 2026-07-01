<?php

namespace App\Services;

use App\Models\AnalysisReport;
use App\Models\CategoryBreakdown;
use App\Models\Transaction;
use App\Models\AiInsight;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AnalysisService
{
    public function calculate(): AnalysisReport
    {
        $userId = Auth::id();
        $transactions = Transaction::where('user_id', $userId)->get();

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;
        $transactionCount = $transactions->count();

        $categoryTotals = $transactions->groupBy('category')->map(function ($group) {
            return $group->sum('amount');
        });

        $topCategory = $categoryTotals->sortDesc()->keys()->first() ?? null;
        $analysis = AnalysisReport::create([
            'user_id' => $userId,
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'balance' => $balance,
            'transaction_count' => $transactionCount,
            'top_category' => $topCategory,
        ]);

        $breakdowns = $categoryTotals->map(function ($amount, $category) use ($totalExpense, $totalIncome) {
            $total = $totalIncome + $totalExpense;
            $percentage = $total > 0 ? ($amount / $total) * 100 : 0;

            return new CategoryBreakdown([
                'category' => $category,
                'percentage' => $percentage,
            ]);
        });

        $analysis->breakdowns()->saveMany($breakdowns);

        AiInsight::create([
            'user_id' => $userId,
            'insight' => $this->generateInsight($analysis, $categoryTotals),
        ]);

        return $analysis;
    }

    public function latest()
    {
        return AnalysisReport::where('user_id', Auth::id())
            ->with('breakdowns')
            ->latest('created_at')
            ->first();
    }

    protected function generateInsight(AnalysisReport $analysis, $categoryTotals): string
    {
        $groqKey = config('services.groq.key');

        if (! $groqKey) {
            return $this->generateFallbackInsight($analysis, $categoryTotals);
        }

        $endpoint = rtrim(config('services.groq.endpoint', 'https://api.groq.ai/v1'), '/');
        $model = config('services.groq.model', 'groq-1.5-mini');
        $prompt = $this->buildGroqPrompt($analysis, $categoryTotals);

        try {
            $response = Http::withToken($groqKey)
                ->acceptJson()
                ->timeout(15)
                ->post($endpoint.'/chat/completions', [
                    'model' => $model,
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a helpful financial assistant.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'max_tokens' => 300,
                    'temperature' => 0.7,
                ]);

            if ($response->successful()) {
                $content = $response->json('choices.0.message.content');
                if ($content) {
                    return trim($content);
                }
            }

            Log::warning('Groq AI response invalid', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        } catch (\Throwable $exception) {
            Log::warning('Groq AI request failed', [
                'message' => $exception->getMessage(),
            ]);
        }

        return $this->generateFallbackInsight($analysis, $categoryTotals);
    }

    protected function buildGroqPrompt(AnalysisReport $analysis, $categoryTotals): string
    {
        $lines = [
            'Buat ringkasan wawasan keuangan untuk pengguna berikut:',
            "Total pendapatan Rp {$analysis->total_income}",
            "Total pengeluaran Rp {$analysis->total_expense}",
            "Saldo Rp {$analysis->balance}",
            "Kategori teratas: " . ($analysis->top_category ?: 'Tidak ada'),
            "Rincian kategori:",
        ];

        foreach ($categoryTotals as $category => $amount) {
            $lines[] = "- {$category}: Rp {$amount}";
        }

        $lines[] = 'Berikan satu saran praktis dalam bahasa Indonesia untuk pengguna agar memperbaiki kondisi keuangan mereka.';

        return implode("\n", $lines);
    }

    protected function generateFallbackInsight(AnalysisReport $analysis, $categoryTotals): string
    {
        $message = "Total income is Rp {$analysis->total_income} and total expense is Rp {$analysis->total_expense}.";

        if ($analysis->top_category) {
            $message .= " Top category is {$analysis->top_category}.";
        }

        if ($analysis->balance < 0) {
            $message .= ' You have negative balance; consider cutting costs.';
        }

        return $message;
    }
}
