@extends('layouts.app')

@section('page-title', 'Profile')
@section('page-subtitle', 'User profile — informasi dan preferensi pengguna.')

@section('content')
<div class="grid gap-6 lg:grid-cols-2">
    <div class="fintrack-card">
        <p class="text-sm font-semibold text-slate-500">Account Info</p>
        <h2 class="mt-2 text-2xl font-semibold text-slate-900">Data Pengguna</h2>
        <div class="mt-6 space-y-4">
            <div class="rounded-[20px] border border-slate-200 bg-slate-50 p-5">
                <p class="text-sm text-slate-500">Name</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ Auth::user()->name }}</p>
            </div>
            <div class="rounded-[20px] border border-slate-200 bg-slate-50 p-5">
                <p class="text-sm text-slate-500">Email</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>

    <div class="fintrack-card">
        <p class="text-sm font-semibold text-slate-500">Preferences</p>
        <h2 class="mt-2 text-2xl font-semibold text-slate-900">Atur Preferensi</h2>
        <div class="mt-6 space-y-4">
            <div class="rounded-[20px] border border-slate-200 bg-slate-50 p-5">
                <p class="text-sm text-slate-500">Theme</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">Light</p>
            </div>
            <div class="rounded-[20px] border border-slate-200 bg-slate-50 p-5">
                <p class="text-sm text-slate-500">Notifications</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">Active</p>
            </div>
        </div>
    </div>
</div>
@endsection
