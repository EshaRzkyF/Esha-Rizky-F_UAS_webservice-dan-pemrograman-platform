@extends('layouts.app')

@section('page-title', 'Categories')
@section('page-subtitle', 'Module categories — klasifikasi pengeluaran Anda.')

@section('content')
<div class="fintrack-card">
    <div class="flex items-center justify-between gap-4 mb-5">
        <div>
            <p class="text-sm font-semibold text-slate-500">Categories</p>
            <h2 class="mt-2 text-2xl font-semibold text-slate-900">Daftar Kategori</h2>
            <p class="mt-2 text-sm text-slate-500">Pastikan setiap transaksi masuk ke kategori yang benar.</p>
        </div>
        <button type="button" data-modal-target="categoryModal" class="fintrack-btn-primary">Tambah Kategori</button>
    </div>
    @if(session('status'))
        <div class="mb-5 rounded-[24px] border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-[24px] border border-slate-200">
        <table class="min-w-full fintrack-table bg-white">
            <thead>
                <tr>
                    <th class="px-6">Nama Kategori</th>
                    <th class="px-6">Jenis</th>
                    <th class="px-6">Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories ?? [] as $category)
                    <tr>
                        <td class="px-6 py-5">{{ $category->name }}</td>
                        <td class="px-6 py-5">{{ $category->type }}</td>
                        <td class="px-6 py-5">{{ $category->description }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-5 text-center text-slate-500" colspan="3">Belum ada kategori. Silakan tambah kategori baru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="categoryModal" class="modal-backdrop hidden">
    <div class="modal-panel">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h3 class="text-xl font-semibold text-slate-900">Tambah Kategori Baru</h3>
                <p class="mt-1 text-sm text-slate-500">Tambahkan kategori transaksi baru dengan cepat.</p>
            </div>
            <button type="button" data-modal-close class="rounded-full bg-slate-100 p-2 text-slate-600 transition hover:bg-slate-200">×</button>
        </div>

        <form action="{{ route('web.categories.store') }}" method="POST" class="mt-6 space-y-5">
            @csrf
            <div class="grid gap-4 md:grid-cols-2">
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Nama Kategori</span>
                    <input type="text" name="name" class="mt-2 w-full rounded-[20px] border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100" required>
                </label>
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Jenis</span>
                    <select name="type" class="mt-2 w-full rounded-[20px] border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100" required>
                        <option value="expense">Expense</option>
                        <option value="income">Income</option>
                    </select>
                </label>
            </div>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Deskripsi</span>
                <textarea name="description" rows="4" class="mt-2 w-full rounded-[20px] border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100"></textarea>
            </label>
            <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                <button type="button" data-modal-close class="fintrack-btn-soft w-full sm:w-auto">Batal</button>
                <button type="submit" class="fintrack-btn-primary w-full sm:w-auto">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>
@endsection
