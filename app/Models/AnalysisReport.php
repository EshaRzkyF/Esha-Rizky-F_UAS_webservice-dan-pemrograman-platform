<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalysisReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_income',
        'total_expense',
        'balance',
        'transaction_count',
        'top_category',
    ];

    protected $casts = [
        'total_income' => 'decimal:2',
        'total_expense' => 'decimal:2',
        'balance' => 'decimal:2',
        'transaction_count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function breakdowns()
    {
        return $this->hasMany(CategoryBreakdown::class);
    }
}
