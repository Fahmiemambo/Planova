@extends('layouts.app')

@section('title', $task->title)

@php
    $breadcrumbs = [
        ['label' => 'Tasks', 'url' => route('tasks.index')],
        ['label' => $task->title],
    ];
@endphp

@section('content')

{{-- ── Task Header ──────────────────────────────────────── --}}
<div class="flex flex-col md:flex-row justify-between items-start gap-4 mb-8">
    <div class="flex-1 min-w-0">
        <div class="flex items-center gap-2 mb-3 flex-wrap">
            <span class="badge-p {{ $task->status_badge_class }}">{{ $task->status_label }}</span>
            @if($task->due_date)
                <span class="text-xs font-medium {{ $task->is_overdue ? 'text-red-600 dark:text-red-400' : 'text-text-secondary dark:text-text-darkSecondary' }} bg-surface-200 dark:bg-dark-surface2 px-2 py-0.5 rounded-full flex items-center gap-1">
                    <i class="bi bi-calendar3"></i> {{ $task->due_date->format('d M Y') }}
                    @if($task->is_overdue) <span class="text-red-600 dark:text-red-400 ml-1">(Overdue)</span>@endif
                </span>
            @endif
        </div>
        <h1 class="text-3xl font-bold text-text-main dark:text-text-darkMain leading-tight mb-2 break-words">{{ $task->title }}</h1>
        @if($task->description)
            <p class="text-base text-text-secondary dark:text-text-darkSecondary break-words">{{ $task->description }}</p>
        @endif
    </div>
    
    <div class="flex items-center gap-2 shrink-0">
        <a href="{{ route('tasks.edit', $task) }}" class="btn-planova btn-secondary-p">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Hapus task ini beserta semua block-nya?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-planova btn-danger-p">
                <i class="bi bi-trash"></i> Hapus
            </button>
        </form>
    </div>
</div>

{{-- ── Block Editor ──────────────────────────────────────── --}}
<div class="max-w-4xl animate-fade-in">
    <div class="flex items-center justify-between mb-4 px-2">
        <span class="text-sm font-semibold text-text-secondary dark:text-text-darkSecondary flex items-center gap-2 uppercase tracking-wide">
            <i class="bi bi-file-text"></i>Konten
        </span>
        <div id="block-saving" class="text-sm text-green-600 dark:text-green-500 font-medium flex items-center gap-1 opacity-0 transition-opacity">
            <i class="bi bi-cloud-check"></i>Tersimpan
        </div>
    </div>

    <div class="bg-surface-200 dark:bg-dark-surface border border-surface-500 dark:border-dark-border rounded-2xl p-4 sm:p-8 min-h-[400px] shadow-sm relative group/editor" id="block-editor-body">

        {{-- Existing blocks --}}
        <div id="block-list" data-blockable-type="App\Models\Task" data-blockable-id="{{ $task->id }}" class="space-y-1">
            @forelse($task->blocks as $block)
                @include('components.block.item', ['block' => $block])
            @empty
                <div id="block-placeholder" class="text-text-muted dark:text-text-darkMuted text-base py-2 font-medium">
                    Mulai menulis atau ketik '/' untuk melihat perintah…
                </div>
            @endforelse
        </div>

        {{-- Add block button --}}
        <div class="relative mt-4 opacity-0 group-hover/editor:opacity-100 transition-opacity focus-within:opacity-100">
            <button class="flex items-center gap-2 text-text-muted dark:text-text-darkMuted hover:text-text-main dark:hover:text-text-darkMain font-medium px-2 py-1.5 rounded hover:bg-surface-100 dark:hover:bg-dark-surface2 transition-colors w-full text-left" id="block-add-btn" type="button">
                <i class="bi bi-plus text-xl"></i> Tambah Block
            </button>

            {{-- Block type menu --}}
            <div class="block-type-menu hidden absolute left-0 top-full mt-2 w-64 bg-surface-200 dark:bg-dark-surface border border-surface-500 dark:border-dark-border rounded-xl shadow-lg dark:shadow-dark-lg z-50 py-2" id="block-type-menu">
                <div class="px-3 pb-2 mb-2 border-b border-surface-500 dark:border-dark-border text-xs font-semibold text-text-muted dark:text-text-darkMuted uppercase tracking-wider">Basic blocks</div>
                
                @foreach([
                    ['type'=>'text',        'icon'=>'bi-text-paragraph',   'label'=>'Teks',         'desc'=>'Paragraf teks biasa'],
                    ['type'=>'heading',     'icon'=>'bi-type-h2',          'label'=>'Heading',      'desc'=>'Judul H1/H2/H3'],
                    ['type'=>'todo',        'icon'=>'bi-check2-square',    'label'=>'To-do list',   'desc'=>'Checklist item'],
                    ['type'=>'bullet_list', 'icon'=>'bi-list-ul',          'label'=>'Bulleted list','desc'=>'Daftar poin sederhana'],
                    ['type'=>'table',       'icon'=>'bi-table',            'label'=>'Tabel',        'desc'=>'Tabel baris & kolom'],
                    ['type'=>'divider',     'icon'=>'bi-dash-lg',          'label'=>'Divider',      'desc'=>'Garis pemisah'],
                ] as $blockType)
                <button type="button" class="block-type-option w-full text-left px-3 py-2 flex items-center gap-3 hover:bg-surface-100 dark:hover:bg-dark-surface2 transition-colors focus:outline-none focus:bg-surface-100 dark:focus:bg-dark-surface2" data-type="{{ $blockType['type'] }}">
                    <div class="w-10 h-10 rounded-lg bg-surface-100 dark:bg-dark-surface2 border border-surface-500 dark:border-dark-border flex items-center justify-center flex-shrink-0 text-text-secondary dark:text-text-darkSecondary">
                        <i class="bi {{ $blockType['icon'] }} text-lg"></i>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-text-main dark:text-text-darkMain">{{ $blockType['label'] }}</div>
                        <div class="text-xs text-text-muted dark:text-text-darkMuted mt-0.5">{{ $blockType['desc'] }}</div>
                    </div>
                </button>
                @endforeach
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.3/Sortable.min.js"></script>
<script>
    window.PLANOVA = window.PLANOVA || {};
    window.PLANOVA.blockRoutes = {
        store:   '{{ route('blocks.store') }}',
        update:  '{{ url('blocks') }}',
        destroy: '{{ url('blocks') }}',
        reorder: '{{ route('blocks.reorder') }}',
    };
    window.PLANOVA.blockable = {
        type: 'App\\Models\\Task',
        id:   {{ $task->id }},
    };
</script>
<script src="{{ asset('js/block-editor.js') }}"></script>
@endpush
