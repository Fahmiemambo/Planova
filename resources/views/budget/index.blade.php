@extends('layouts.app')

@section('title', 'Budget')
@section('page_title', 'Budgeting')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-text-main dark:text-text-darkMain mb-1">Budget</h1>
        <p class="text-sm text-text-muted dark:text-text-darkMuted">Rencanakan batas pengeluaran bulanan Anda.</p>
    </div>
    <a href="#" class="btn-planova btn-primary-p shrink-0" onclick="alert('Fitur tambah budget sedang dikembangkan.')">
        <i class="bi bi-plus-lg"></i> Buat Budget
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($budgets as $budget)
        <div class="pcard animate-stagger-card opacity-0">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-surface-100 dark:bg-dark-surface2 flex items-center justify-center text-2xl mb-2">
                    {{ ['🍕', '🚗', '🛍️', '💡', '🎮', '✈️'][rand(0,5)] }}
                </div>
                <button class="text-text-muted hover:text-text-main dark:text-text-darkMuted dark:hover:text-text-darkMain p-1">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
            </div>
            
            <h3 class="text-lg font-semibold text-text-main dark:text-text-darkMain mb-1">{{ $budget->name }}</h3>
            <p class="text-sm text-text-muted dark:text-text-darkMuted mb-4">Bulan ini</p>
            
            <div class="mb-2 flex justify-between items-end">
                <span class="text-xl font-bold text-text-main dark:text-text-darkMain">Rp {{ number_format($budget->spent_amount, 0, ',', '.') }}</span>
                <span class="text-sm font-medium text-text-muted dark:text-text-darkMuted">/ Rp {{ number_format($budget->limit_amount, 0, ',', '.') }}</span>
            </div>
            
            <x-progress-bar :value="$budget->spent_amount" :max="$budget->limit_amount" :showText="true" height="h-2" />
            
            @php $remaining = $budget->limit_amount - $budget->spent_amount; @endphp
            <div class="mt-4 pt-4 border-t border-surface-500 dark:border-dark-border text-sm flex justify-between">
                <span class="text-text-secondary dark:text-text-darkSecondary">Sisa Budget</span>
                <span class="font-semibold {{ $remaining >= 0 ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-400' }}">
                    Rp {{ number_format(abs($remaining), 0, ',', '.') }}
                </span>
            </div>
        </div>
    @empty
        <div class="col-span-full pcard text-center py-16">
            <div class="text-5xl mb-4">🎯</div>
            <h2 class="text-lg font-semibold text-text-main dark:text-text-darkMain mb-2">Belum ada Budget</h2>
            <p class="text-sm text-text-muted dark:text-text-darkMuted mb-6">Atur batas pengeluaran untuk mengontrol keuangan Anda.</p>
            <button class="btn-planova btn-primary-p">Buat Budget Sekarang</button>
        </div>
    @endforelse
</div>
@endsection
