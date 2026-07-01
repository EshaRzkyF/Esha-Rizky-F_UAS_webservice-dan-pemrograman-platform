<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryBreakdown extends Model
{
    use HasFactory;

    protected $fillable = [
        'analysis_report_id',
        'category',
        'percentage',
    ];

    protected $casts = [
        'percentage' => 'decimal:2',
    ];

    public function analysisReport()
    {
        return $this->belongsTo(AnalysisReport::class);
    }
}
