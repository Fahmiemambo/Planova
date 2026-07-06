@extends('layouts.app')

@section('title', 'Dashboard')
@section('meta_description', 'Ringkasan produktivitas dan keuangan Anda di Planova')
@section('page_title', 'Dashboard')

@section('content')

{{-- ── Greeting Header ─────────────────────────────────── --}}
<div class="mb-7 flex items-center justify-between gap-4 flex-wrap">
    <div>
        <h1 class="text-3xl font-extrabold text-primary-dark leading-tight mb-1">
            Halo, <span class="text-primary">{{ auth()->user()->name }}</span> 👋
        </h1>
        <p class="text-sm font-bold text-text-muted">
            {{ now()->format('l, d F Y') }} — Ini ringkasan workspace Anda hari ini.
        </p>
    </div>
    <div class="flex items-center gap-2 flex-shrink-0">
        <a href="{{ route('finance.create') }}" class="btn-planova btn-secondary-p btn-sm-p hidden sm:inline-flex">
            <i class="bi bi-plus-lg"></i> Transaksi
        </a>
        <a href="{{ route('tasks.create') }}" class="btn-planova btn-primary-p">
            <i class="bi bi-plus-lg"></i> Task Baru
        </a>
    </div>
</div>

{{-- ── Stat Cards ──────────────────────────────────────── --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-7">

    {{-- Tasks Total --}}
    <div class="stat-card animate-stagger-card opacity-0 cursor-pointer hover:scale-[1.02] transition-transform"
         onclick="window.location='{{ route('tasks.index') }}'">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
             style="background: rgba(13,148,136,0.12);">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0D9488" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
        </div>
        <div class="min-w-0">
            <div class="text-2xl font-extrabold text-primary-dark leading-none mb-1">{{ $taskStats['total'] }}</div>
            <div class="text-xs font-extrabold text-text-muted uppercase tracking-wide">Total Tasks</div>
            <div class="mt-1.5 text-xs font-bold">
                <span class="text-amber-600">{{ $taskStats['in_progress'] }} aktif</span>
                <span class="text-text-muted mx-1">·</span>
                <span class="text-green-600">{{ $taskStats['done'] }} selesai</span>
            </div>
        </div>
    </div>

    {{-- Overdue --}}
    <div class="stat-card animate-stagger-card opacity-0 cursor-pointer hover:scale-[1.02] transition-transform"
         onclick="window.location='{{ route('tasks.index', ['status' => 'todo']) }}'">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
             style="background: rgba(239,68,68,0.10);">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>
        <div class="min-w-0">
            <div class="text-2xl font-extrabold leading-none mb-1 {{ $taskStats['overdue'] > 0 ? 'text-red-600' : 'text-primary-dark' }}">
                {{ $taskStats['overdue'] }}
            </div>
            <div class="text-xs font-extrabold text-text-muted uppercase tracking-wide">Overdue</div>
            <div class="mt-1.5 text-xs font-bold {{ $taskStats['overdue'] > 0 ? 'text-red-500' : 'text-green-600' }}">
                {{ $taskStats['overdue'] > 0 ? 'Perlu perhatian segera' : 'Semua on-track ✓' }}
            </div>
        </div>
    </div>

    {{-- Income --}}
    <div class="stat-card animate-stagger-card opacity-0 cursor-pointer hover:scale-[1.02] transition-transform"
         onclick="window.location='{{ route('finance.index') }}'">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
             style="background: rgba(16,185,129,0.12);">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <div class="min-w-0">
            <div class="text-base font-extrabold text-primary-dark leading-tight mb-1 truncate">
                Rp {{ number_format($totalIncome, 0, ',', '.') }}
            </div>
            <div class="text-xs font-extrabold text-text-muted uppercase tracking-wide">Pemasukan</div>
            <div class="mt-1.5 text-xs font-bold text-text-muted">{{ now()->format('M Y') }}</div>
        </div>
    </div>

    {{-- Expense --}}
    <div class="stat-card animate-stagger-card opacity-0 cursor-pointer hover:scale-[1.02] transition-transform"
         onclick="window.location='{{ route('finance.index') }}'">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
             style="background: rgba(245,158,11,0.12);">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        </div>
        <div class="min-w-0">
            <div class="text-base font-extrabold text-primary-dark leading-tight mb-1 truncate">
                Rp {{ number_format($totalExpense, 0, ',', '.') }}
            </div>
            <div class="text-xs font-extrabold text-text-muted uppercase tracking-wide">Pengeluaran</div>
            <div class="mt-1.5 text-xs font-extrabold {{ $netBalance >= 0 ? 'text-green-600' : 'text-red-500' }}">
                Net {{ $netBalance >= 0 ? '+' : '' }}Rp {{ number_format($netBalance, 0, ',', '.') }}
            </div>
        </div>
    </div>

</div>

{{-- ── Two-column main section ──────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

    {{-- Recent Tasks --}}
    <div class="pcard animate-stagger-card opacity-0 flex flex-col">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-primary/10 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0D9488" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                </div>
                <h2 class="text-base font-extrabold text-primary-dark">Tasks Aktif</h2>
            </div>
            <a href="{{ route('tasks.index') }}" class="btn-planova btn-ghost-p btn-sm-p text-xs">
                Lihat semua
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>

        @if($recentTasks->isEmpty())
            <div class="flex-1 flex flex-col items-center justify-center py-10 px-4 text-center">
                <div class="w-14 h-14 rounded-2xl bg-primary/8 flex items-center justify-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0D9488" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                </div>
                <div class="text-sm font-extrabold text-primary-dark mb-1">Belum ada task aktif</div>
                <p class="text-xs text-text-muted font-bold mb-3">Buat task pertama Anda sekarang</p>
                <a href="{{ route('tasks.create') }}" class="btn-planova btn-primary-p btn-sm-p">
                    <i class="bi bi-plus"></i> Buat Task
                </a>
            </div>
        @else
            <div class="divide-y divide-surface-400/50 flex-1">
                @foreach($recentTasks as $task)
                    <a href="{{ route('tasks.show', $task) }}"
                       class="flex items-center gap-3 py-3 group hover:bg-primary/4 px-2 -mx-2 rounded-xl transition-colors cursor-pointer">
                        <span class="badge-p {{ $task->status_badge_class }} flex-shrink-0 text-[10px]">
                            {{ $task->status_label }}
                        </span>
                        <span class="flex-1 text-sm font-bold text-primary-dark truncate group-hover:text-primary transition-colors">
                            {{ $task->title }}
                        </span>
                        @if($task->due_date)
                            <span class="text-xs flex-shrink-0 font-bold {{ $task->is_overdue ? 'text-red-500' : 'text-text-muted' }}">
                                @if($task->is_overdue)
                                    <i class="bi bi-exclamation-circle mr-0.5"></i>
                                @endif
                                {{ $task->due_date->format('d M') }}
                            </span>
                        @endif
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-primary/30 group-hover:text-primary/60 transition-colors flex-shrink-0"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                @endforeach
            </div>
            <div class="mt-4 pt-3 border-t border-surface-400/40">
                <a href="{{ route('tasks.create') }}" class="btn-planova btn-secondary-p btn-sm-p w-full justify-center text-xs">
                    <i class="bi bi-plus"></i> Tambah Task Baru
                </a>
            </div>
        @endif
    </div>

    {{-- Recent Finance --}}
    <div class="pcard animate-stagger-card opacity-0 flex flex-col">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-green-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h2 class="text-base font-extrabold text-primary-dark">Transaksi Terbaru</h2>
            </div>
            <a href="{{ route('finance.index') }}" class="btn-planova btn-ghost-p btn-sm-p text-xs">
                Lihat semua
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>

        @if($recentFinance->isEmpty())
            <div class="flex-1 flex flex-col items-center justify-center py-10 px-4 text-center">
                <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                </div>
                <div class="text-sm font-extrabold text-primary-dark mb-1">Belum ada transaksi</div>
                <p class="text-xs text-text-muted font-bold mb-3">Catat pemasukan atau pengeluaran Anda</p>
                <a href="{{ route('finance.create') }}" class="btn-planova btn-primary-p btn-sm-p">
                    <i class="bi bi-plus"></i> Tambah Transaksi
                </a>
            </div>
        @else
            <div class="divide-y divide-surface-400/50 flex-1">
                @foreach($recentFinance as $record)
                    <div class="flex items-center gap-3 py-3">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0 {{ $record->type === 'income' ? 'bg-green-100' : 'bg-red-100' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="{{ $record->type === 'income' ? '#059669' : '#DC2626' }}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                @if($record->type === 'income')
                                    <line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/>
                                @else
                                    <line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/>
                                @endif
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-bold text-primary-dark truncate">
                                {{ $record->description ?? ($record->category?->name ?? 'Transaksi') }}
                            </div>
                            @if($record->category)
                            <div class="text-xs text-text-muted font-bold truncate">{{ $record->category->name }}</div>
                            @endif
                        </div>
                        <span class="text-sm font-extrabold flex-shrink-0 {{ $record->type === 'income' ? 'text-green-600' : 'text-red-500' }}">
                            {{ $record->type === 'income' ? '+' : '-' }}Rp {{ number_format($record->amount, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 pt-3 border-t border-surface-400/40">
                <a href="{{ route('finance.create') }}" class="btn-planova btn-secondary-p btn-sm-p w-full justify-center text-xs">
                    <i class="bi bi-plus"></i> Tambah Transaksi
                </a>
            </div>
        @endif
    </div>

</div>

{{-- ── Budget Progress ─────────────────────────────────── --}}
@if($budgets->isNotEmpty())
<div class="pcard animate-stagger-card opacity-0">
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg bg-amber-100 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <h2 class="text-base font-extrabold text-primary-dark">Budget Bulan Ini</h2>
        </div>
        <a href="{{ route('budget.index') }}" class="btn-planova btn-ghost-p btn-sm-p text-xs">
            Kelola
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @foreach($budgets as $budget)
            @php
                $pct = $budget->limit_amount > 0 ? min(100, round(($budget->spent_amount / $budget->limit_amount) * 100)) : 0;
                $barColor = $pct >= 90 ? '#EF4444' : ($pct >= 70 ? '#F59E0B' : '#0D9488');
            @endphp
            <div class="bg-white/60 rounded-2xl p-4 border border-white/80">
                <div class="flex justify-between items-center mb-2.5">
                    <span class="text-sm font-extrabold text-primary-dark">{{ $budget->name }}</span>
                    <span class="text-xs font-extrabold {{ $pct >= 90 ? 'text-red-500' : 'text-text-muted' }}">{{ $pct }}%</span>
                </div>
                <x-progress-bar :value="$budget->spent_amount" :max="$budget->limit_amount" :showText="true" />
                <div class="mt-2 flex justify-between text-xs font-bold text-text-muted">
                    <span>Rp {{ number_format($budget->spent_amount, 0, ',', '.') }}</span>
                    <span>/ {{ $budget->formatted_limit }}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

{{-- ── Quick Links ──────────────────────────────────────── --}}
<div class="mt-5 grid grid-cols-2 sm:grid-cols-4 gap-3">
    @foreach([
        [route('analytics.index'), 'bi-graph-up-arrow', 'Analytics', 'bg-violet-100 text-violet-700'],
        [route('documents.index'), 'bi-folder2-open', 'Documents', 'bg-blue-100 text-blue-700'],
        [route('budget.index'), 'bi-bullseye', 'Budget', 'bg-amber-100 text-amber-700'],
        [route('finance.index'), 'bi-cash-coin', 'Finance', 'bg-green-100 text-green-700'],
    ] as [$url, $icon, $label, $colorClass])
    <a href="{{ $url }}"
       class="pcard flex items-center gap-3 py-3 px-4 hover:scale-[1.03] transition-transform cursor-pointer animate-stagger-card opacity-0 text-sm font-extrabold text-primary-dark">
        <span class="w-8 h-8 rounded-xl {{ $colorClass }} flex items-center justify-center flex-shrink-0">
            <i class="bi {{ $icon }}"></i>
        </span>
        {{ $label }}
    </a>
    @endforeach
</div>

@endsection
