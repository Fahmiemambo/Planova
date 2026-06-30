@extends('layouts.app')

@section('title', 'Tambah Transaksi')
@section('page_title', 'Tambah Transaksi')

@php
    $breadcrumbs = [
        ['label' => 'Finance', 'url' => route('finance.index')],
        ['label' => 'Tambah Transaksi'],
    ];
@endphp

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-text-main dark:text-text-darkMain">Tambah Transaksi</h1>
</div>

<div class="max-w-xl">
    <div class="pcard animate-fade-in-up">
        <form method="POST" action="{{ route('finance.store') }}" id="create-finance-form" class="space-y-6">
            @csrf

            {{-- Type selector --}}
            <div>
                <label class="form-label-p">Tipe Transaksi</label>
                <div class="flex gap-4">
                    <label class="flex-1 cursor-pointer group">
                        <input type="radio" name="type" value="income" class="hidden peer type-radio" {{ old('type', 'expense') === 'income' ? 'checked' : '' }}>
                        <div class="p-4 border-2 rounded-xl text-center transition-all peer-checked:border-green-500 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20 border-surface-500 dark:border-dark-border hover:border-green-300 dark:hover:border-green-700/50">
                            <i class="bi bi-arrow-down-circle block text-2xl mb-1 text-surface-400 dark:text-dark-border peer-checked:text-green-500 group-hover:text-green-400 transition-colors"></i>
                            <span class="text-sm font-semibold text-text-secondary dark:text-text-darkSecondary peer-checked:text-green-600 dark:peer-checked:text-green-400">Pemasukan</span>
                        </div>
                    </label>
                    <label class="flex-1 cursor-pointer group">
                        <input type="radio" name="type" value="expense" class="hidden peer type-radio" {{ old('type', 'expense') === 'expense' ? 'checked' : '' }}>
                        <div class="p-4 border-2 rounded-xl text-center transition-all peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/20 border-surface-500 dark:border-dark-border hover:border-red-300 dark:hover:border-red-700/50">
                            <i class="bi bi-arrow-up-circle block text-2xl mb-1 text-surface-400 dark:text-dark-border peer-checked:text-red-500 group-hover:text-red-400 transition-colors"></i>
                            <span class="text-sm font-semibold text-text-secondary dark:text-text-darkSecondary peer-checked:text-red-600 dark:peer-checked:text-red-400">Pengeluaran</span>
                        </div>
                    </label>
                </div>
            </div>

            <div>
                <label for="amount" class="form-label-p">Jumlah (Rp) <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-darkMuted font-medium">Rp</span>
                    <input type="number" id="amount" name="amount" class="form-control-p pl-9 font-semibold" value="{{ old('amount') }}" placeholder="0" min="0.01" step="0.01" required>
                </div>
                @error('amount')<div class="text-sm text-red-500 mt-1">{{ $message }}</div>@enderror
            </div>

            <div>
                <label for="description" class="form-label-p">Deskripsi</label>
                <input type="text" id="description" name="description" class="form-control-p" value="{{ old('description') }}" placeholder="Contoh: Gaji, Makan siang…">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="date" class="form-label-p">Tanggal <span class="text-red-500">*</span></label>
                    <input type="date" id="date" name="date" class="form-control-p" value="{{ old('date', now()->format('Y-m-d')) }}" required>
                </div>

                <div>
                    <label for="category_id" class="form-label-p">Kategori</label>
                    <select id="category_id" name="category_id" class="form-control-p form-select-p">
                        <option value="">Tanpa Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label for="notes" class="form-label-p">Catatan</label>
                <textarea id="notes" name="notes" class="form-control-p" rows="2" placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-planova btn-primary-p">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>
                <a href="{{ route('finance.index') }}" class="btn-planova btn-secondary-p">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
