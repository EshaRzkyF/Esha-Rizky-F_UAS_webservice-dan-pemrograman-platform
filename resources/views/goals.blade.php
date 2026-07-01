@extends('layouts.app')

@section('page-title', 'Goals')
@section('page-subtitle', 'Planning Module — atur target dan lihat progres.')

@section('content')
<div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
    <div>
        <p class="text-sm font-semibold text-slate-500">Planning Module</p>
        <h2 class="mt-2 text-2xl font-semibold text-slate-900">Goals</h2>
        <p class="mt-2 text-sm text-slate-500">Visualisasikan progress target keuangan Anda.</p>
    </div>
    <button type="button" data-modal-target="goalModal" class="fintrack-btn-primary">Tambah Goal</button>
</div>

<div class="grid gap-6 lg:grid-cols-2">
    <div class="fintrack-card">
        <div class="space-y-6">
            @foreach($goals as $goal)
                @php
                    $percent = min(100, max(0, $goal->current_amount / max($goal->target_amount, 1) * 100));
                @endphp
                <div class="rounded-[24px] border border-slate-200 bg-slate-50 p-5">
                    <div class="flex items-center justify-between gap-3 mb-4">
                        <div>
                            <p class="text-sm font-semibold text-slate-700">{{ $goal->name }}</p>
                            <p class="mt-2 text-sm text-slate-500">Rp {{ number_format($goal->current_amount, 2, ',', '.') }} dari Rp {{ number_format($goal->target_amount, 2, ',', '.') }}</p>
                        </div>
                        <span class="fintrack-badge-accent">{{ round($percent) }}%</span>
                    </div>
                    <div class="h-3 overflow-hidden rounded-full bg-slate-200">
                        <div class="h-full rounded-full bg-emerald-600" style="width: {{ $percent }}%"></div>
                    </div>
                    <div class="mt-4 flex items-center justify-between text-sm text-slate-500">
                        <span>{{ $goal->deadline->format('Y-m-d') }}</span>
                        <span>{{ $percent >= 100 ? 'Target tercapai' : 'Dalam proses' }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="fintrack-card space-y-6">
        <div class="rounded-[24px] border border-slate-200 bg-slate-50 p-5">
            <div class="flex items-center justify-between gap-3 mb-4">
                <div>
                    <p class="text-sm font-semibold text-slate-500">Investment Recommendation</p>
                    <h3 class="mt-2 text-xl font-semibold text-slate-900">Informasi</h3>
                </div>
                <span class="fintrack-badge">Info</span>
            </div>
            <p class="text-sm leading-7 text-slate-700">{{ $insight?->insight ?? 'Tetap disiplin dan konsisten untuk mencapai target keuangan Anda.' }}</p>
        </div>
        <div class="rounded-[24px] border border-slate-200 bg-slate-50 p-5">
            <p class="text-sm font-semibold text-slate-500">Saving Simulation</p>
            <p class="mt-3 text-sm leading-7 text-slate-700">Dengan kontribusi rutin setiap bulan, target keuangan bisa tercapai lebih cepat.</p>
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
            <p class="text-sm font-semibold text-slate-700">Pantau Target</p>
            <p class="mt-3 text-sm text-slate-600">Atur alokasi dana sesuai target keuangan Anda.</p>
        </div>
        <div class="rounded-[24px] border border-slate-200 bg-slate-50 p-5">
            <p class="text-sm font-semibold text-slate-700">Evaluasi Bulanan</p>
            <p class="mt-3 text-sm text-slate-600">Perbarui simulasi setiap bulan agar rencana tetap relevan.</p>
        </div>
    </div>
</div>

<div id="goalModal" class="modal-backdrop hidden">
    <div class="modal-panel">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h3 class="text-xl font-semibold text-slate-900">Tambah Goal Baru</h3>
                <p class="mt-1 text-sm text-slate-500">Tambahkan target baru ke Planning Module tanpa keluar halaman.</p>
            </div>
            <button type="button" data-modal-close class="rounded-full bg-slate-100 p-2 text-slate-600 transition hover:bg-slate-200">×</button>
        </div>

        <form action="{{ route('web.goals.store') }}" method="POST" class="mt-6 space-y-5">
            @csrf
            <div class="grid gap-4 md:grid-cols-2">
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Nama Goal</span>
                    <input type="text" name="name" class="mt-2 w-full rounded-[20px] border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100" required>
                </label>
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Target Amount</span>
                    <input type="number" step="0.01" name="target_amount" class="mt-2 w-full rounded-[20px] border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100" required>
                </label>
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Current Amount</span>
                    <input type="number" step="0.01" name="current_amount" class="mt-2 w-full rounded-[20px] border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100" value="0">
                </label>
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Deadline</span>
                    <input type="date" name="deadline" class="mt-2 w-full rounded-[20px] border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100" required>
                </label>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                <button type="button" data-modal-close class="fintrack-btn-soft w-full sm:w-auto">Batal</button>
                <button type="submit" class="fintrack-btn-primary w-full sm:w-auto">Simpan Goal</button>
            </div>
        </form>
    </div>
</div>
@endsection
