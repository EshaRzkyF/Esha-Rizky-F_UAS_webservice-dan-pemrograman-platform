@extends('layouts.app')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan keuangan pribadi Anda.')

@section('content')
<div class="grid gap-6 xl:grid-cols-4">
    <div class="fintrack-card">
        <div class="flex items-center justify-between gap-3">
            <div>
                <p class="text-sm font-semibold text-slate-500">Balance</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">Rp {{ number_format($balance, 2, ',', '.') }}</p>
            </div>
            <span class="fintrack-badge">Core</span>
        </div>
        <p class="mt-4 text-sm text-slate-500">Saldo keseluruhan antara pemasukan dan pengeluaran dalam modul ini.</p>
    </div>

    <div class="fintrack-card">
        <p class="text-sm font-semibold text-slate-500">Income</p>
        <p class="mt-3 text-3xl font-semibold text-slate-900">Rp {{ number_format($totalIncome, 2, ',', '.') }}</p>
        <p class="mt-4 text-sm text-slate-500">Total pemasukan yang tercatat di periode ini.</p>
    </div>

    <div class="fintrack-card">
        <p class="text-sm font-semibold text-slate-500">Expense</p>
        <p class="mt-3 text-3xl font-semibold text-slate-900">Rp {{ number_format($totalExpense, 2, ',', '.') }}</p>
        <p class="mt-4 text-sm text-slate-500">Total pengeluaran yang sudah terjadi saat ini.</p>
    </div>

    <div class="fintrack-card">
        <p class="text-sm font-semibold text-slate-500">Savings</p>
        <p class="mt-3 text-3xl font-semibold text-slate-900">Rp {{ number_format(max(0, $totalIncome - $totalExpense), 2, ',', '.') }}</p>
        <p class="mt-4 text-sm text-slate-500">Estimasi dana yang bisa dialokasikan ke tujuan perencanaan.</p>
    </div>
</div>

<div class="grid gap-6 xl:grid-cols-[1.5fr_0.9fr]">
    <div class="fintrack-card">
        <div class="flex items-center justify-between gap-4 mb-5">
            <div>
                <p class="text-sm font-semibold text-slate-500">Income vs Expense</p>
                <h2 class="mt-2 text-xl font-semibold text-slate-900">Trend Bulanan</h2>
            </div>
            <span class="fintrack-badge-accent">Chart</span>
        </div>
        <div class="h-[340px]">
            <canvas id="dashboardOverviewChart" class="h-full w-full"></canvas>
        </div>
    </div>

    <div class="fintrack-card">
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-slate-500">Ringkasan</p>
                    <h2 class="mt-2 text-xl font-semibold text-slate-900">Catatan Keuangan</h2>
                </div>
                <span class="fintrack-badge">Info</span>
            </div>
            <div class="rounded-[20px] bg-emerald-50 p-5 text-slate-800">
                <p class="font-semibold">Total Transaksi</p>
                <p class="mt-3 text-sm leading-7 text-slate-700">Anda memiliki {{ $transactions->count() }} transaksi tercatat. Pantau terus pemasukan dan pengeluaran Anda.</p>
            </div>
            <div class="grid gap-3">
                <div class="rounded-[20px] border border-slate-200 bg-white p-4">
                    <p class="text-sm font-semibold text-slate-500">Pemasukan</p>
                    <p class="mt-2 text-sm text-slate-700">Rp {{ number_format($totalIncome, 2, ',', '.') }}</p>
                </div>
                <div class="rounded-[20px] border border-slate-200 bg-white p-4">
                    <p class="text-sm font-semibold text-slate-500">Pengeluaran</p>
                    <p class="mt-2 text-sm text-slate-700">Rp {{ number_format($totalExpense, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="fintrack-card">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-sm font-semibold text-slate-500">Recent Transactions</p>
            <h2 class="mt-2 text-xl font-semibold text-slate-900">Aktivitas Terbaru</h2>
        </div>
        <a href="{{ route('transactions') }}" class="fintrack-btn-soft">Go to Transactions</a>
    </div>

    <div class="mt-6 overflow-hidden rounded-[24px] border border-slate-200">
        <table class="min-w-full fintrack-table bg-white">
            <thead>
                <tr>
                    <th class="px-6">Tanggal</th>
                    <th class="px-6">Deskripsi</th>
                    <th class="px-6">Kategori</th>
                    <th class="px-6">Jumlah</th>
                    <th class="px-6">Tipe</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td class="px-6">{{ $transaction->date->format('Y-m-d') }}</td>
                        <td class="px-6">{{ $transaction->description }}</td>
                        <td class="px-6"><span class="fintrack-badge-accent">{{ $transaction->category }}</span></td>
                        <td class="px-6">Rp {{ number_format($transaction->amount, 2, ',', '.') }}</td>
                        <td class="px-6">{{ $transaction->type === 'income' ? 'Income' : 'Expense' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ctxOverview = document.getElementById('dashboardOverviewChart');
    if (ctxOverview) {
        new Chart(ctxOverview, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [
                    {
                        label: 'Income',
                        data: [{{ max(0, $totalIncome / 4) }}, {{ max(0, $totalIncome / 4) }}, {{ max(0, $totalIncome / 4) }}, {{ max(0, $totalIncome / 4) }}],
                        borderColor: '#16a34a',
                        backgroundColor: 'rgba(34, 197, 94, 0.16)',
                        tension: 0.3,
                        fill: true,
                        pointRadius: 4,
                    },
                    {
                        label: 'Expense',
                        data: [{{ max(0, $totalExpense / 4) }}, {{ max(0, $totalExpense / 4) }}, {{ max(0, $totalExpense / 4) }}, {{ max(0, $totalExpense / 4) }}],
                        borderColor: '#f97316',
                        backgroundColor: 'rgba(249, 115, 22, 0.16)',
                        tension: 0.3,
                        fill: true,
                        pointRadius: 4,
                    }
                ]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, grid: { color: 'rgba(15, 23, 42, 0.08)' } }
                }
            }
        });
    }
</script>
@endpush
