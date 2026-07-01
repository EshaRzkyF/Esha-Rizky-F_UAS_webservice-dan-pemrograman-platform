@extends('layouts.guest')

@section('content')
<div class="grid gap-8 lg:grid-cols-[1.2fr_0.8fr] py-10">
    <div class="fintrack-card">
        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">FinTrack</p>
        <h1 class="mt-4 text-4xl font-semibold text-slate-900">Dashboard keuangan yang rapi dan profesional.</h1>
        <p class="mt-4 max-w-2xl text-base leading-8 text-slate-600">Lacak pemasukan, pengeluaran, tujuan, dan rencana keuangan dalam satu dashboard yang rapi dan mudah digunakan.</p>
        <div class="mt-8 flex flex-wrap gap-3">
            @guest
                <a href="{{ route('login') }}" class="fintrack-btn-primary">Masuk</a>
                <a href="{{ route('register') }}" class="fintrack-btn-soft">Daftar</a>
            @else
                <a href="{{ route('dashboard') }}" class="fintrack-btn-primary">Buka Dasbor</a>
            @endguest
        </div>
    </div>

    <div class="grid gap-4">
        <div class="fintrack-card bg-[#f3fdf7]">
            <p class="text-sm font-semibold text-emerald-700">Transaksi</p>
            <p class="mt-3 text-slate-700">Tambahkan pemasukan dan pengeluaran, kategorikan, dan lihat aktivitas terbaru.</p>
        </div>
        <div class="fintrack-card bg-[#f8fafc]">
            <p class="text-sm font-semibold text-slate-700">Tujuan</p>
            <p class="mt-3 text-slate-700">Tetapkan target tabungan, pantau kemajuan, dan tetap termotivasi untuk mencapai milestone penting.</p>
        </div>
        <div class="fintrack-card bg-[#f8fafc]">
            <p class="text-sm font-semibold text-slate-700">Perencanaan</p>
            <p class="mt-3 text-slate-700">Buat rencana keuangan dan tinjau rekomendasi untuk anggaran yang lebih baik.</p>
        </div>
        <div class="fintrack-card bg-[#f8fafc]">
            <p class="text-sm font-semibold text-slate-700">Analisis</p>
            <p class="mt-3 text-slate-700">Tinjau wawasan pengeluaran dan rincian kategori untuk membuat keputusan yang lebih cerdas.</p>
        </div>
    </div>
</div>
@endsection
