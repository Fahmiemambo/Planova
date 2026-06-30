@extends('layouts.app')

@section('title', 'Notes')
@section('page_title', 'Notes')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-text-main dark:text-text-darkMain mb-1">Notes</h1>
        <p class="text-sm text-text-muted dark:text-text-darkMuted">Catatan bebas, jurnal, dan dokumen panjang.</p>
    </div>
    <form action="{{ route('notes.store') }}" method="POST">
        @csrf
        <button type="submit" class="btn-planova btn-primary-p shrink-0">
            <i class="bi bi-file-earmark-plus"></i> Buat Note Baru
        </button>
    </form>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($notes as $note)
        <a href="{{ route('notes.show', $note) }}" class="pcard block animate-stagger-card opacity-0 hover:-translate-y-1 transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-lg bg-surface-100 dark:bg-dark-surface2 flex items-center justify-center text-text-main dark:text-text-darkMain group-hover:bg-primary group-hover:text-white transition-colors">
                    <i class="bi {{ $note->icon ?: 'bi-file-earmark-text' }} text-lg"></i>
                </div>
            </div>
            
            <h3 class="text-base font-semibold text-text-main dark:text-text-darkMain mb-2 truncate group-hover:text-primary dark:group-hover:text-primary-light transition-colors">{{ $note->title }}</h3>
            
            <div class="text-xs text-text-muted dark:text-text-darkMuted mt-4 pt-4 border-t border-surface-500 dark:border-dark-border flex justify-between items-center">
                <span>Diperbarui</span>
                <span>{{ $note->updated_at->diffForHumans() }}</span>
            </div>
        </a>
    @empty
        <div class="col-span-full pcard text-center py-16">
            <div class="text-5xl text-surface-500 dark:text-dark-border mb-4">📝</div>
            <h2 class="text-lg font-semibold text-text-main dark:text-text-darkMain mb-2">Belum ada Catatan</h2>
            <p class="text-sm text-text-muted dark:text-text-darkMuted mb-6">Mulai tulis catatan harian, dokumentasi, atau ide-ide kreatif Anda.</p>
            <form action="{{ route('notes.store') }}" method="POST">
                @csrf
                <button type="submit" class="btn-planova btn-primary-p inline-flex">Buat Note Pertama</button>
            </form>
        </div>
    @endforelse
</div>
@endsection
