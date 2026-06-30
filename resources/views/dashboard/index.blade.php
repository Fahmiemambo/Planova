@extends('layouts.app')

@section('title', 'Dashboard')
@section('meta_description', 'Ringkasan produktivitas dan keuangan Anda di Planova')
@section('page_title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-text-main dark:text-text-darkMain mb-1">Dashboard</h1>
    <p class="text-sm text-text-muted dark:text-text-darkMuted">Selamat datang, {{ auth()->user()->name }}! Ini ringkasan hari ini.</p>
</div>

{{-- ── Stat Cards ──────────────────────────────────────── --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

    {{-- Tasks Total --}}
    <div class="stat-card animate-stagger-card opacity-0">
        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 bg-primary-light text-primary dark:bg-primary/20 dark:text-primary-light">
            <i class="bi bi-check2-square text-lg"></i>
        </div>
        <div>
            <div class="text-2xl font-bold text-text-main dark:text-text-darkMain leading-none mb-1">{{ $taskStats['total'] }}</div>
            <div class="text-xs font-semibold text-text-muted dark:text-text-darkMuted uppercase tracking-wide">Total Tasks</div>
            <div class="mt-2 text-xs text-text-muted dark:text-text-darkMuted">
                <span class="text-amber-600 dark:text-amber-500">{{ $taskStats['in_progress'] }} in progress</span>
                <span class="mx-1">&middot;</span>
                <span class="text-green-600 dark:text-green-500">{{ $taskStats['done'] }} selesai</span>
            </div>
        </div>
    </div>

    {{-- Overdue Tasks --}}
    <div class="stat-card animate-stagger-card opacity-0">
        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400">
            <i class="bi bi-exclamation-triangle text-lg"></i>
        </div>
        <div>
            <div class="text-2xl font-bold leading-none mb-1 {{ $taskStats['overdue'] > 0 ? 'text-red-600 dark:text-red-400' : 'text-text-main dark:text-text-darkMain' }}">
                {{ $taskStats['overdue'] }}
            </div>
            <div class="text-xs font-semibold text-text-muted dark:text-text-darkMuted uppercase tracking-wide">Overdue</div>
            <div class="mt-2 text-xs text-text-muted dark:text-text-darkMuted">
                {{ $taskStats['overdue'] > 0 ? 'Perlu perhatian segera' : 'Semua on-track 🎉' }}
            </div>
        </div>
    </div>

    {{-- Income This Month --}}
    <div class="stat-card animate-stagger-card opacity-0">
        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 bg-green-50 text-green-600 dark:bg-green-900/30 dark:text-green-500">
            <i class="bi bi-arrow-down-circle text-lg"></i>
        </div>
        <div>
            <div class="text-lg font-bold text-text-main dark:text-text-darkMain leading-tight mb-1 truncate max-w-[120px]">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
            <div class="text-xs font-semibold text-text-muted dark:text-text-darkMuted uppercase tracking-wide truncate">Pemasukan Bulan Ini</div>
            <div class="mt-2 text-xs text-text-muted dark:text-text-darkMuted">{{ now()->format('F Y') }}</div>
        </div>
    </div>

    {{-- Expense This Month --}}
    <div class="stat-card animate-stagger-card opacity-0">
        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-500">
            <i class="bi bi-arrow-up-circle text-lg"></i>
        </div>
        <div>
            <div class="text-lg font-bold text-text-main dark:text-text-darkMain leading-tight mb-1 truncate max-w-[120px]">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
            <div class="text-xs font-semibold text-text-muted dark:text-text-darkMuted uppercase tracking-wide truncate">Pengeluaran Bulan Ini</div>
            <div class="mt-2 text-xs font-medium {{ $netBalance >= 0 ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-400' }}">
                Net: Rp {{ number_format(abs($netBalance), 0, ',', '.') }}
                {{ $netBalance >= 0 ? '↑' : '↓' }}
            </div>
        </div>
    </div>

</div>

{{-- ── Two-column section ─────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

    {{-- Recent Tasks --}}
    <div class="pcard animate-stagger-card opacity-0">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-semibold text-text-main dark:text-text-darkMain">Tasks Aktif</h2>
            <a href="{{ route('tasks.index') }}" class="btn-planova btn-ghost-p btn-sm-p">Lihat semua</a>
        </div>

        @if($recentTasks->isEmpty())
            <div class="text-center py-10 px-4">
                <div class="text-4xl text-surface-500 dark:text-dark-border mb-4">✅</div>
                <div class="text-sm font-semibold text-text-main dark:text-text-darkMain mb-2">Tidak ada task aktif</div>
                <a href="{{ route('tasks.create') }}" class="btn-planova btn-primary-p btn-sm-p mt-2">
                    <i class="bi bi-plus"></i> Buat Task
                </a>
            </div>
        @else
            <div class="divide-y divide-surface-500 dark:divide-dark-border">
                @foreach($recentTasks as $task)
                    <a href="{{ route('tasks.show', $task) }}" class="flex items-center gap-3 py-3 group hover:bg-surface-100 dark:hover:bg-dark-bg transition-colors px-2 -mx-2 rounded-lg">
                        <span class="badge-p {{ $task->status_badge_class }} flex-shrink-0 text-[10px]">
                            {{ $task->status_label }}
                        </span>
                        <span class="flex-1 text-sm font-medium text-text-main dark:text-text-darkMain truncate group-hover:text-primary dark:group-hover:text-primary-light transition-colors">
                            {{ $task->title }}
                        </span>
                        @if($task->due_date)
                            <span class="text-xs flex-shrink-0 {{ $task->is_overdue ? 'text-red-600 dark:text-red-400 font-medium' : 'text-text-muted dark:text-text-darkMuted' }}">
                                {{ $task->due_date->format('d M') }}
                            </span>
                        @endif
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Recent Finance --}}
    <div class="pcard animate-stagger-card opacity-0">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-semibold text-text-main dark:text-text-darkMain">Transaksi Terbaru</h2>
            <a href="{{ route('finance.index') }}" class="btn-planova btn-ghost-p btn-sm-p">Lihat semua</a>
        </div>

        @if($recentFinance->isEmpty())
            <div class="text-center py-10 px-4">
                <div class="text-4xl text-surface-500 dark:text-dark-border mb-4">💳</div>
                <div class="text-sm font-semibold text-text-main dark:text-text-darkMain mb-2">Belum ada transaksi</div>
                <a href="{{ route('finance.create') }}" class="btn-planova btn-primary-p btn-sm-p mt-2">
                    <i class="bi bi-plus"></i> Tambah
                </a>
            </div>
        @else
            <div class="divide-y divide-surface-500 dark:divide-dark-border">
                @foreach($recentFinance as $record)
                    <div class="flex items-center gap-3 py-3">
                        <span class="badge-p {{ $record->type === 'income' ? 'badge-income' : 'badge-expense' }} flex-shrink-0 text-[10px]">
                            {{ $record->type === 'income' ? 'In' : 'Out' }}
                        </span>
                        <span class="flex-1 text-sm text-text-main dark:text-text-darkMain truncate">
                            {{ $record->description ?? ($record->category?->name ?? 'Transaksi') }}
                        </span>
                        <span class="text-sm font-semibold flex-shrink-0 {{ $record->type === 'income' ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-400' }}">
                            {{ $record->type === 'income' ? '+' : '-' }}Rp {{ number_format($record->amount, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>

{{-- ── Budget Progress ─────────────────────────────────── --}}
@if($budgets->isNotEmpty())
<div class="pcard animate-stagger-card opacity-0">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-base font-semibold text-text-main dark:text-text-darkMain">Budget Bulan Ini</h2>
        <a href="{{ route('budget.index') }}" class="btn-planova btn-ghost-p btn-sm-p">Kelola</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($budgets as $budget)
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <span class="text-sm font-medium text-text-main dark:text-text-darkMain">{{ $budget->name }}</span>
                    <span class="text-xs text-text-muted dark:text-text-darkMuted">
                        Rp {{ number_format($budget->spent_amount, 0, ',', '.') }} / {{ $budget->formatted_limit }}
                    </span>
                </div>
                <x-progress-bar :value="$budget->spent_amount" :max="$budget->limit_amount" :showText="true" />
            </div>
        @endforeach
    </div>
</div>
@endif

@endsection
