@extends('layouts.app')

@section('page-title', 'Transactions')
@section('page-subtitle', 'Transaction Module — kelola transaksi keuangan Anda.')

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
        <div>
            <p class="text-sm font-semibold text-slate-500">Transaction Module</p>
            <h2 class="mt-2 text-2xl font-semibold text-slate-900">Daftar Transaksi</h2>
            <p class="mt-2 text-sm text-slate-500">Kelola pencatatan transaksi secara bersih dan terstruktur.</p>
        </div>
        <button type="button" data-modal-target="transactionModal" class="fintrack-btn-primary">+ Add Transaction</button>
    </div>

    <div class="fintrack-card-soft">
        <form action="{{ route('transactions') }}" method="GET" class="grid gap-4 lg:grid-cols-[1fr_0.7fr_0.6fr]">
            <div>
                <label class="block text-sm font-medium text-slate-600">Tanggal</label>
                <input name="date" type="date" value="{{ request('date') }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100" />
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-600">Kategori</label>
                <select name="category" class="mt-2 w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100">
                    <option value="all" {{ request('category') === 'all' ? 'selected' : '' }}>Semua Kategori</option>
                    @foreach($categories as $categoryOption)
                        <option value="{{ $categoryOption }}" {{ request('category') === $categoryOption ? 'selected' : '' }}>{{ $categoryOption }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end justify-end gap-3">
                <a href="{{ route('transactions') }}" class="fintrack-btn-soft w-full text-center">Reset</a>
                <button type="submit" class="fintrack-btn-primary w-full">Apply</button>
            </div>
        </form>
    </div>

    <div class="fintrack-card">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500">Transaction Table</p>
                <h2 class="mt-2 text-xl font-semibold text-slate-900">Clean Table</h2>
            </div>
            <span class="fintrack-badge">Terkelola</span>
        </div>

        <div class="mt-6 overflow-hidden rounded-[24px] border border-slate-200">
            <table class="min-w-full fintrack-table bg-white">
                <thead>
                    <tr>
                        <th class="px-6">Date</th>
                        <th class="px-6">Description</th>
                        <th class="px-6">Category</th>
                        <th class="px-6">Amount</th>
                        <th class="px-6">Type</th>
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

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="fintrack-card">
            <p class="text-sm font-semibold text-slate-500">Transaction Count</p>
            <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $transactions->count() }}</p>
            <p class="mt-4 text-sm text-slate-500">Jumlah transaksi yang berlangsung di modul ini.</p>
        </div>
        <div class="fintrack-card">
            <p class="text-sm font-semibold text-slate-500">Popular Categories</p>
            <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $transactions->pluck('category')->unique()->count() }}</p>
            <p class="mt-4 text-sm text-slate-500">Kategori aktif yang paling sering muncul.</p>
        </div>
    </div>
</div>

<div id="transactionModal" class="modal-backdrop hidden">
    <div class="modal-panel">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h3 class="text-xl font-semibold text-slate-900">Tambah Transaksi Baru</h3>
                <p class="mt-1 text-sm text-slate-500">Gunakan modal ini untuk menambah transaksi tanpa berpindah halaman.</p>
            </div>
            <button type="button" data-modal-close class="rounded-full bg-slate-100 p-2 text-slate-600 transition hover:bg-slate-200">×</button>
        </div>

        <form action="{{ route('web.transactions.store') }}" method="POST" class="mt-6 space-y-5">
            @csrf
            <div class="grid gap-4 md:grid-cols-2">
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Tanggal</span>
                    <input type="date" name="date" class="mt-2 w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100" required>
                </label>
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Type</span>
                    <select name="type" class="mt-2 w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100" required>
                        <option value="income">Income</option>
                        <option value="expense">Expense</option>
                    </select>
                </label>
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Amount</span>
                    <input type="number" step="0.01" name="amount" class="mt-2 w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100" required>
                </label>
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Category</span>
                    <input type="text" name="category" class="mt-2 w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100" placeholder="Makanan, Transport" required>
                </label>
            </div>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Description</span>
                <textarea name="description" rows="4" class="mt-2 w-full rounded-[24px] border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100" placeholder="Catatan singkat"></textarea>
            </label>
            <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                <button type="button" data-modal-close class="fintrack-btn-soft w-full sm:w-auto">Batal</button>
                <button type="submit" class="fintrack-btn-primary w-full sm:w-auto">Simpan Transaksi</button>
            </div>
        </form>
    </div>
</div>
@endsection
