<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AiInsight;
use App\Services\AnalysisService;
use Illuminate\Support\Facades\Auth;

class AnalysisController extends Controller
{
    public function __construct(protected AnalysisService $service)
    {
    }

    public function summary()
    {
        $report = $this->service->latest();
        $insight = AiInsight::where('user_id', Auth::id())->latest('created_at')->first();

        return view('analysis', compact('report', 'insight'));
    }

    public function insights()
    {
        return redirect()->route('analysis.summary');
    }

    public function generate()
    {
        $this->service->calculate();

        return redirect()->route('analysis.summary')->with('status', 'Analisis terbaru telah dibuat.');
    }
}
