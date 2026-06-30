@extends('layouts.app')

@section('title', 'Finance')
@section('page_title', 'Finance')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-text-main dark:text-text-darkMain mb-1">Finance</h1>
        <p class="text-sm text-text-muted dark:text-text-darkMuted">Catat pemasukan dan pengeluaran Anda.</p>
    </div>
    <a href="{{ route('finance.create') }}" class="btn-planova btn-primary-p shrink-0">
        <i class="bi bi-plus-lg"></i> Tambah Transaksi
    </a>
</div>

{{-- Summary cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="stat-card animate-stagger-card opacity-0">
        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 bg-green-50 text-green-600 dark:bg-green-900/30 dark:text-green-500">
            <i class="bi bi-arrow-down-circle text-lg"></i>
        </div>
        <div>
            <div class="text-xl font-bold text-green-600 dark:text-green-500 leading-tight mb-1">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
            <div class="text-xs font-semibold text-text-muted dark:text-text-darkMuted uppercase tracking-wide">Pemasukan</div>
        </div>
    </div>
    <div class="stat-card animate-stagger-card opacity-0">
        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400">
            <i class="bi bi-arrow-up-circle text-lg"></i>
        </div>
        <div>
            <div class="text-xl font-bold text-red-600 dark:text-red-400 leading-tight mb-1">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
            <div class="text-xs font-semibold text-text-muted dark:text-text-darkMuted uppercase tracking-wide">Pengeluaran</div>
        </div>
    </div>
    <div class="stat-card animate-stagger-card opacity-0">
        @php $net = $totalIncome - $totalExpense; @endphp
        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 {{ $net >= 0 ? 'bg-primary-light text-primary dark:bg-primary/20 dark:text-primary-light' : 'bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-500' }}">
            <i class="bi bi-wallet2 text-lg"></i>
        </div>
        <div>
            <div class="text-xl font-bold leading-tight mb-1 {{ $net >= 0 ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-400' }}">
                {{ $net >= 0 ? '+' : '' }}Rp {{ number_format($net, 0, ',', '.') }}
            </div>
            <div class="text-xs font-semibold text-text-muted dark:text-text-darkMuted uppercase tracking-wide">Saldo Bersih</div>
        </div>
    </div>
</div>

{{-- Filter bar --}}
<div class="mb-6 pcard py-3 px-4">
    <form method="GET" action="{{ route('finance.index') }}" class="flex flex-wrap gap-3 items-center">
        <div class="w-full sm:w-auto">
            <select name="type" class="form-control-p form-select-p sm:w-40" onchange="this.form.submit()">
                <option value="">Semua Tipe</option>
                <option value="income"  {{ request('type') === 'income'  ? 'selected' : '' }}>Pemasukan</option>
                <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
        </div>
        <div class="w-full sm:w-auto">
            <select name="category_id" class="form-control-p form-select-p sm:w-48" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="w-full sm:w-auto">
            <input type="month" name="month" value="{{ $month }}" class="form-control-p sm:w-40" onchange="this.form.submit()">
        </div>
        @if(request()->hasAny(['type','category_id','month']))
            <a href="{{ route('finance.index') }}" class="btn-planova btn-ghost-p btn-sm-p shrink-0">
                <i class="bi bi-x-circle"></i> Reset
            </a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="pcard p-0 overflow-hidden">
    @if($records->isEmpty())
        <div class="text-center py-16 px-6">
            <div class="text-5xl text-surface-500 dark:text-dark-border mb-4">💸</div>
            <div class="text-lg font-semibold text-text-main dark:text-text-darkMain mb-2">Belum ada transaksi</div>
            <p class="text-sm text-text-muted dark:text-text-darkMuted mb-6">Mulai catat pemasukan atau pengeluaran Anda.</p>
            <a href="{{ route('finance.create') }}" class="btn-planova btn-primary-p">
                <i class="bi bi-plus-lg"></i> Tambah Pertama
            </a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="ptable min-w-[700px]">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Tipe</th>
                        <th>Deskripsi</th>
                        <th>Kategori</th>
                        <th class="text-right">Jumlah</th>
                        <th class="w-20"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-500 dark:divide-dark-border">
                    @foreach($records as $record)
                    <tr class="animate-stagger-card opacity-0 group">
                        <td class="text-xs text-text-muted dark:text-text-darkMuted whitespace-nowrap">
                            {{ $record->date->format('d M Y') }}
                        </td>
                        <td>
                            <span class="badge-p {{ $record->type === 'income' ? 'badge-income' : 'badge-expense' }}">
                                {{ $record->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                            </span>
                        </td>
                        <td>
                            <div class="text-sm font-medium text-text-main dark:text-text-darkMain">
                                {{ $record->description ?: '—' }}
                            </div>
                            @if($record->notes)
                                <div class="text-xs text-text-muted dark:text-text-darkMuted mt-0.5 truncate max-w-xs">{{ Str::limit($record->notes, 50) }}</div>
                            @endif
                        </td>
                        <td>
                            @if($record->category)
                                <span class="inline-block px-2 py-0.5 bg-surface-300 dark:bg-dark-surface2 rounded-full text-xs text-text-secondary dark:text-text-darkSecondary">
                                    {{ $record->category->name }}
                                </span>
                            @else
                                <span class="text-text-muted dark:text-text-darkMuted text-xs">—</span>
                            @endif
                        </td>
                        <td class="text-right font-bold {{ $record->type === 'income' ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-400' }} whitespace-nowrap">
                            {{ $record->type === 'income' ? '+' : '-' }}Rp {{ number_format($record->amount, 0, ',', '.') }}
                        </td>
                        <td>
                            <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('finance.edit', $record) }}" class="btn-planova btn-ghost-p p-1.5" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('finance.destroy', $record) }}" onsubmit="return confirm('Hapus transaksi ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-planova btn-ghost-p text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 p-1.5" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($records->hasPages())
            <div class="px-6 py-4 border-t border-surface-500 dark:border-dark-border">
                {{ $records->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
