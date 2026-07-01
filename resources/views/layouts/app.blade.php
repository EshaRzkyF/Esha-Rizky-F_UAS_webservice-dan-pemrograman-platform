<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'FinTrack') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-slate-50 text-slate-900">
<div class="fintrack-shell">
    <aside id="sidebar" class="fintrack-sidebar">
        <div class="space-y-3 mt-6">
            <div>
                <div class="text-2xl font-semibold text-emerald-600">FinTrack</div>
                <p class="text-sm text-slate-500">Kelola keuangan pribadi Anda dalam satu dashboard.</p>
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <div class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">Dashboard</div>
                <a href="{{ route('dashboard') }}" class="mt-3 flex items-center gap-3 rounded-3xl px-4 py-3 text-sm font-medium text-slate-800 transition hover:bg-emerald-50 @if(request()->routeIs('dashboard')) bg-emerald-50 text-emerald-700 @endif">
                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-600"></span>
                    Dashboard
                </a>
            </div>

            <div>
                <div class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">TRANSACTION MODULE</div>
                <div class="mt-3 space-y-2">
                    <a href="{{ route('transactions') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-sm font-medium text-slate-800 transition hover:bg-emerald-50 @if(request()->routeIs('transactions')) bg-emerald-50 text-emerald-700 @endif">
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-600"></span>
                        Transactions
                    </a>
                    <a href="{{ route('categories') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-sm font-medium text-slate-800 transition hover:bg-emerald-50 @if(request()->routeIs('categories')) bg-emerald-50 text-emerald-700 @endif">
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-600"></span>
                        Categories
                    </a>
                </div>
            </div>

            <div>
                <div class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">ANALYSIS MODULE</div>
                <div class="mt-3 space-y-2">
                    <a href="{{ route('analysis.summary') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-sm font-medium text-slate-800 transition hover:bg-emerald-50 @if(request()->routeIs('analysis.summary')) bg-emerald-50 text-emerald-700 @endif">
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-600"></span>
                        Summary
                    </a>
                    <a href="{{ route('analysis.insights') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-sm font-medium text-slate-800 transition hover:bg-emerald-50 @if(request()->routeIs('analysis.insights')) bg-emerald-50 text-emerald-700 @endif">
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-600"></span>
                        Insights
                    </a>
                </div>
            </div>

            <div>
                <div class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">PLANNING MODULE</div>
                <div class="mt-3 space-y-2">
                    <a href="{{ route('goals') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-sm font-medium text-slate-800 transition hover:bg-emerald-50 @if(request()->routeIs('goals')) bg-emerald-50 text-emerald-700 @endif">
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-600"></span>
                        Goals
                    </a>
                    <a href="{{ route('planning') }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-sm font-medium text-slate-800 transition hover:bg-emerald-50 @if(request()->routeIs('planning')) bg-emerald-50 text-emerald-700 @endif">
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-600"></span>
                        Recommendation
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-auto space-y-4">
            <div class="rounded-[24px] border border-slate-200/80 bg-slate-50 p-5">
                <div class="text-xs uppercase tracking-[0.2em] text-slate-400">Profile</div>
                <a href="{{ route('profile') }}" class="mt-3 block rounded-3xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700">Account</a>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="">
                @csrf
                <button type="submit" class="w-full rounded-3xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">Logout</button>
            </form>
        </div>
    </aside>

    <main class="fintrack-main">
        <div class="flex flex-col gap-5 lg:gap-6">
            <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                <div>
                    <h1 class="fintrack-title">@yield('page-title', 'Dashboard')</h1>
                    <p class="fintrack-subtitle">@yield('page-subtitle', 'Kelola keuangan pribadi Anda.')</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <button id="themeToggle" class="fintrack-btn-soft">Toggle theme</button>
                    <span class="fintrack-badge">Hosted</span>
                </div>
            </div>

            @if(session('status'))
                <div id="status-toast" class="toast">{{ session('status') }}</div>
            @endif
            @if($errors->any())
                <div class="rounded-[24px] border border-rose-200 bg-rose-50 p-5 text-sm text-rose-700">
                    <ul class="space-y-2 mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</div>

<div id="toast" class="toast"></div>
<script>
    const themeToggle = document.getElementById('themeToggle');
    const root = document.documentElement;
    const storedTheme = localStorage.getItem('fintrack-theme');

    if (storedTheme === 'dark') {
        root.classList.add('dark');
    }

    themeToggle?.addEventListener('click', () => {
        root.classList.toggle('dark');
        localStorage.setItem('fintrack-theme', root.classList.contains('dark') ? 'dark' : 'light');
    });

    function openModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.remove('hidden');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.add('hidden');
    }

    function showToast(message) {
        const toast = document.getElementById('toast');
        if (!toast) return;
        toast.textContent = message;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 4000);
    }

    document.addEventListener('click', event => {
        let target = event.target;
        if (!(target instanceof Element)) {
            target = target.parentElement;
        }
        if (!target) {
            return;
        }

        const modalTarget = target.closest('[data-modal-target]');
        if (modalTarget) {
            const targetId = modalTarget.getAttribute('data-modal-target');
            openModal(targetId);
            return;
        }

        const modalClose = target.closest('[data-modal-close]');
        if (modalClose) {
            const modal = modalClose.closest('.modal-backdrop');
            if (modal) closeModal(modal.id);
            return;
        }

        if (target.classList.contains('modal-backdrop')) {
            closeModal(target.id);
        }
    });

    window.addEventListener('DOMContentLoaded', () => {
        const statusToast = document.getElementById('status-toast');
        if (statusToast) {
            showToast(statusToast.textContent.trim());
            statusToast.remove();
        }
    });
</script>
@stack('scripts')
</body>
</html>
