@extends('layouts.app')

@section('page-title', 'Analysis')
@section('page-subtitle', 'Analysis Module — analisis keuangan untuk memahami tren Anda.')

@section('content')
<div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
    <div class="fintrack-card">
        <div class="flex flex-col gap-3">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold text-slate-500">Analysis Module</p>
                    <h2 class="mt-2 text-2xl font-semibold text-slate-900">Ringkasan Keuangan</h2>
                </div>
                <form action="{{ route('analysis.generate') }}" method="POST">
                    @csrf
                    <button type="submit" class="fintrack-btn-primary">Refresh</button>
                </form>
            </div>
            <p class="text-sm text-slate-500">Kontrol ringkasan keuangan dan lihat data utama untuk analisis modul.</p>
        </div>

        <div class="mt-6 grid gap-4 md:grid-cols-3">
            <div class="fintrack-card-soft">
                <p class="text-sm font-semibold text-slate-500">Total Income</p>
                <p class="mt-3 text-2xl font-semibold text-slate-900">Rp {{ number_format($report?->total_income ?? 0, 2, ',', '.') }}</p>
            </div>
            <div class="fintrack-card-soft">
                <p class="text-sm font-semibold text-slate-500">Total Expense</p>
                <p class="mt-3 text-2xl font-semibold text-slate-900">Rp {{ number_format($report?->total_expense ?? 0, 2, ',', '.') }}</p>
            </div>
            <div class="fintrack-card-soft">
                <p class="text-sm font-semibold text-slate-500">Net Balance</p>
                <p class="mt-3 text-2xl font-semibold text-slate-900">Rp {{ number_format($report?->balance ?? 0, 2, ',', '.') }}</p>
            </div>
        </div>

        <div class="mt-6 rounded-[24px] border border-slate-200 bg-slate-50 p-5">
            <p class="text-sm font-semibold text-slate-500">Ringkasan</p>
            <p class="mt-3 text-sm leading-7 text-slate-700">{{ $insight?->insight ?? 'Belum ada ringkasan. Klik Refresh untuk membuat analisis.' }}</p>
        </div>
    </div>

    <div class="fintrack-card flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-slate-500">Informasi</p>
                    <h2 class="mt-2 text-xl font-semibold text-slate-900">Rekomendasi</h2>
                </div>
                <span class="fintrack-badge">Info</span>
            </div>
            <p class="mt-4 text-sm leading-7 text-slate-600">Gunakan data ini untuk menyesuaikan rencana pengeluaran dan alokasi dana.</p>
        </div>

        <div class="mt-6 rounded-[20px] bg-emerald-50 p-4 text-sm text-emerald-700">
            <p class="font-semibold">Catatan</p>
            <p class="mt-2">Optimalkan pengeluaran Anda dan alokasikan dana untuk tabungan bulanan.</p>
        </div>
    </div>
</div>

<div class="grid gap-6 xl:grid-cols-[1.4fr_0.6fr]">
    <div class="fintrack-card">
        <div class="flex items-center justify-between gap-4 mb-5">
            <div>
                <p class="text-sm font-semibold text-slate-500">Category Breakdown</p>
                <h3 class="mt-2 text-xl font-semibold text-slate-900">Distribusi Pengeluaran</h3>
            </div>
            <span class="fintrack-badge-accent">Visual</span>
        </div>
        <div class="h-[320px]">
            <canvas id="analysisCategoryChart" class="h-full w-full"></canvas>
        </div>
    </div>

    <div class="fintrack-card">
        <div class="grid gap-4">
            @if($report && $report->breakdowns->count())
                @foreach($report->breakdowns as $breakdown)
                    <div class="space-y-3 rounded-[20px] border border-slate-200/70 bg-slate-50 p-4">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-sm font-semibold text-slate-700">{{ $breakdown->category }}</p>
                            <span class="text-sm font-semibold text-slate-500">{{ number_format($breakdown->percentage, 2) }}%</span>
                        </div>
                        <div class="h-3 overflow-hidden rounded-full bg-slate-200">
                            <div class="h-full rounded-full bg-emerald-600" style="width: {{ $breakdown->percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="rounded-[24px] border border-dashed border-slate-300 p-6 text-sm text-slate-500">
                    Belum ada data breakdown kategori. Klik Refresh untuk memulai analisis.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ctxCategory = document.getElementById('analysisCategoryChart');
    if (ctxCategory) {
        new Chart(ctxCategory, {
            type: 'doughnut',
            data: {
                labels: [
                    @foreach($report?->breakdowns ?? collect() as $breakdown)
                        '{{ $breakdown->category }}',
                    @endforeach
                ],
                datasets: [{
                    data: [
                        @foreach($report?->breakdowns ?? collect() as $breakdown)
                            {{ $breakdown->percentage }},
                        @endforeach
                    ],
                    backgroundColor: ['#16a34a', '#22c55e', '#4ade80', '#86efac', '#d9f99d'],
                    hoverOffset: 10,
                }]
            },
            options: {
                plugins: { legend: { position: 'bottom', labels: { color: '#334155', boxWidth: 12 } } },
                maintainAspectRatio: false,
            }
        });
    }
</script>
@endpush
