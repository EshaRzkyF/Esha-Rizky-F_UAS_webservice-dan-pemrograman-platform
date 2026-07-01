@extends('layouts.guest')

@section('content')
<div class="grid min-h-[calc(100vh-4rem)] place-items-center py-10">
    <div class="w-full max-w-xl">
        <div class="fintrack-card">
            <div class="mb-6">
                <p class="text-sm font-semibold text-slate-500">Mulai Sekarang</p>
                <h1 class="mt-3 text-3xl font-semibold text-slate-900">Daftar FinTrack</h1>
                <p class="mt-3 text-sm text-slate-500">Buat akun untuk mulai mengelola keuangan pribadi Anda.</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 rounded-[20px] border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                    <ul class="space-y-2 mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.perform') }}" class="space-y-5">
                @csrf
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Nama</span>
                    <input type="text" name="name" value="{{ old('name') }}" class="mt-2 w-full rounded-[20px] border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100" required>
                </label>
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Email</span>
                    <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-[20px] border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100" required>
                </label>
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Kata Sandi</span>
                    <input type="password" name="password" class="mt-2 w-full rounded-[20px] border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100" required>
                </label>
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Konfirmasi Kata Sandi</span>
                    <input type="password" name="password_confirmation" class="mt-2 w-full rounded-[20px] border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100" required>
                </label>
                <button type="submit" class="fintrack-btn-primary w-full">Daftar</button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-500">Sudah punya akun? <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-700">Masuk di sini</a></p>
        </div>
    </div>
</div>
@endsection
