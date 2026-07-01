@extends('layouts.app')

@section('page-title', 'Investment Recommendation')
@section('page-subtitle', 'Planning Module — simulasi perencanaan investasi.')

@section('content')
<div class="grid gap-6 xl:grid-cols-[1.4fr_0.6fr]">
    <div class="fintrack-card">
        <div class="flex items-center justify-between gap-4 mb-5">
            <div>
                <p class="text-sm font-semibold text-slate-500">Planning Module</p>
                <h2 class="mt-2 text-2xl font-semibold text-slate-900">Rencana Investasi</h2>
            </div>
            <span class="fintrack-badge">Recommendation</span>
        </div>

        <div class="grid gap-4 lg:grid-cols-2">
            <div class="rounded-[24px] border border-slate-200 bg-slate-50 p-5">
                <p class="text-sm font-semibold text-slate-500">Rendah Risiko</p>
                <p class="mt-3 text-sm leading-7 text-slate-700">Alokasikan ke reksa dana pasar uang dan obligasi jangka pendek untuk stabilitas.</p>
            </div>
            <div class="rounded-[24px] border border-slate-200 bg-slate-50 p-5">
                <p class="text-sm font-semibold text-slate-500">Pertumbuhan</p>
                <p class="mt-3 text-sm leading-7 text-slate-700">Gunakan indeks saham dan portofolio pertumbuhan dengan horizon 3-5 tahun.</p>
            </div>
        </div>

        <div class="mt-6 grid gap-4 lg:grid-cols-2">
            <div class="rounded-[24px] border border-slate-200 bg-white p-5">
                <p class="text-sm font-semibold text-slate-500">Current Balance</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">Rp {{ number_format($plan?->balance ?? 0, 2, ',', '.') }}</p>
                <p class="mt-3 text-sm text-slate-500">Saldo saat ini yang dapat ditargetkan untuk investasi.</p>
            </div>
            <div class="rounded-[24px] border border-slate-200 bg-white p-5">
                <p class="text-sm font-semibold text-slate-500">Target Saving</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">Rp {{ number_format($plan?->saving_target ?? 0, 2, ',', '.') }}</p>
                <p class="mt-3 text-sm text-slate-500">Target tabungan yang direkomendasikan.</p>
            </div>
        </div>

        <div class="mt-6 rounded-[24px] border border-emerald-200 bg-emerald-50 p-6">
            <p class="text-sm font-semibold text-emerald-700">Informasi</p>
            <p class="mt-3 text-sm leading-7 text-emerald-800">{{ $insight?->insight ?? 'Pertahankan alokasi dana secara konsisten untuk mencapai target investasi Anda.' }}</p>
        </div>
    </div>

    <div class="fintrack-card">
        <div class="flex items-center justify-between gap-4 mb-5">
            <div>
                <p class="text-sm font-semibold text-slate-500">Goal Progress</p>
                <h2 class="mt-2 text-xl font-semibold text-slate-900">Status Target</h2>
            </div>
            <span class="fintrack-badge-accent">Planning</span>
        </div>

        <div class="space-y-5">
            @foreach($goals as $goal)
                @php
                    $percent = min(100, max(0, $goal->current_amount / max($goal->target_amount, 1) * 100));
                @endphp
                <div class="rounded-[24px] border border-slate-200 bg-slate-50 p-5">
                    <div class="flex items-center justify-between gap-3 mb-4">
                        <div>
                            <p class="text-sm font-semibold text-slate-700">{{ $goal->name }}</p>
                            <p class="mt-2 text-sm text-slate-500">Rp {{ number_format($goal->current_amount, 2, ',', '.') }} / Rp {{ number_format($goal->target_amount, 2, ',', '.') }}</p>
                        </div>
                        <span class="text-sm font-semibold text-slate-500">{{ round($percent) }}%</span>
                    </div>
                    <div class="h-3 overflow-hidden rounded-full bg-slate-200">
                        <div class="h-full rounded-full bg-emerald-600 transition-all duration-1000" style="width: {{ $percent }}%"></div>
                    </div>
                    <p class="mt-4 text-sm text-slate-500">Deadline: {{ $goal->deadline->format('Y-m-d') }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="fintrack-card mt-6">
    <div class="flex items-center justify-between gap-4 mb-5">
        <div>
            <p class="text-sm font-semibold text-slate-500">Action Plan</p>
            <h2 class="mt-2 text-xl font-semibold text-slate-900">Langkah Modular</h2>
        </div>
    </div>
    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-[24px] border border-slate-200 bg-slate-50 p-5">
            <p class="text-sm font-semibold text-slate-700">Pisahkan Target</p>
            <p class="mt-3 text-sm text-slate-600">Buat goal pendek, menengah, dan panjang dalam modul Planning.</p>
        </div>
        <div class="rounded-[24px] border border-slate-200 bg-slate-50 p-5">
            <p class="text-sm font-semibold text-slate-700">Sesuaikan Target</p>
            <p class="mt-3 text-sm text-slate-600">Sesuaikan alokasi dana secara berkala agar rencana tetap relevan.</p>
        </div>
        <div class="rounded-[24px] border border-slate-200 bg-slate-50 p-5">
            <p class="text-sm font-semibold text-slate-700">Evaluasi Bulanan</p>
            <p class="mt-3 text-sm text-slate-600">Perbarui simulasi setiap bulan agar rencana tetap relevan.</p>
        </div>
    </div>
</div>
@endsection
