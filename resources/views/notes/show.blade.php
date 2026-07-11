@extends('layouts.app')

@section('title', $note->title)

@php
    $breadcrumbs = [
        ['label' => 'Notes', 'url' => route('notes.index')],
        ['label' => Str::limit($note->title, 20)],
    ];
@endphp

@section('content')

{{-- Note Header with inline editing --}}
<div class="max-w-4xl mx-auto mb-8 animate-fade-in pt-8">
    <div class="relative group/title">
        {{-- Icon --}}
        <div class="text-4xl sm:text-6xl mb-4 cursor-pointer hover:opacity-80 transition-opacity inline-block" title="Ubah Icon">
            <i class="bi {{ $note->icon ?: 'bi-file-earmark-text' }} text-text-main dark:text-text-darkMain"></i>
        </div>

        {{-- Title Input (transparent) --}}
        <input type="text" id="note-title-input" class="w-full text-4xl sm:text-5xl font-bold text-text-main dark:text-text-darkMain bg-transparent border-none outline-none placeholder-surface-500 dark:placeholder-dark-border focus:ring-0 p-0 mb-4" value="{{ $note->title }}" placeholder="Untitled Note" onblur="saveNoteMeta()" onkeypress="if(event.key === 'Enter') this.blur();">
        
        <div class="flex items-center gap-4 text-xs text-text-muted dark:text-text-darkMuted">
            <span>Dibuat {{ $note->created_at->format('d M Y') }}</span>
            <span>&middot;</span>
            <form method="POST" action="{{ route('notes.destroy', $note) }}" data-ajax="true" data-confirm-message="Hapus catatan ini selamanya?" data-redirect-url="{{ route('notes.index') }}">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-600 dark:hover:text-red-400 transition-colors">Hapus Note</button>
            </form>
            <div id="note-saving-indicator" class="ml-auto text-green-600 dark:text-green-500 font-medium opacity-0 transition-opacity">
                <i class="bi bi-cloud-check mr-1"></i>Tersimpan
            </div>
        </div>
    </div>
</div>

{{-- ── Block Editor (Notion-like) ──────────────────────────────────────── --}}
<div class="max-w-4xl mx-auto animate-fade-in" style="animation-delay: 100ms;">

    <div class="min-h-[500px] relative group/editor" id="block-editor-body">

        {{-- Existing blocks --}}
        <div id="block-list" data-blockable-type="App\Models\Note" data-blockable-id="{{ $note->id }}" class="space-y-1">
            @forelse($note->blocks as $block)
                @include('components.block.item', ['block' => $block])
            @empty
                <div id="block-placeholder" class="text-text-muted dark:text-text-darkMuted text-lg py-2 font-medium">
                    Mulai menulis atau ketik '/' untuk melihat perintah…
                </div>
            @endforelse
        </div>

        {{-- Add block button --}}
        <div class="relative mt-6 opacity-0 group-hover/editor:opacity-100 transition-opacity focus-within:opacity-100 pb-16">
            <button class="flex items-center gap-2 text-text-muted dark:text-text-darkMuted hover:text-text-main dark:hover:text-text-darkMain font-medium px-2 py-1.5 rounded hover:bg-surface-100 dark:hover:bg-dark-surface2 transition-colors text-left" id="block-add-btn" type="button">
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
    // Config for block-editor.js
    window.PLANOVA = window.PLANOVA || {};
    window.PLANOVA.blockRoutes = {
        store:   '{{ route('blocks.store') }}',
        update:  '{{ url('blocks') }}',
        destroy: '{{ url('blocks') }}',
        reorder: '{{ route('blocks.reorder') }}',
    };
    window.PLANOVA.blockable = {
        type: 'App\\Models\\Note',
        id:   {{ $note->id }},
    };

    // Note Meta Saving (Title)
    function saveNoteMeta() {
        const title = document.getElementById('note-title-input').value;
        const indicator = document.getElementById('note-saving-indicator');
        
        indicator.innerHTML = '<i class="bi bi-arrow-repeat animate-spin mr-1"></i>Menyimpan…';
        indicator.style.opacity = '1';

        fetch('{{ route('notes.update', $note) }}', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ title: title })
        }).then(res => res.json()).then(data => {
            if(data.success) {
                indicator.innerHTML = '<i class="bi bi-cloud-check mr-1"></i>Tersimpan';
                setTimeout(() => indicator.style.opacity = '0', 2000);
            }
        });
    }
</script>
<script src="{{ asset('js/block-editor.js') }}"></script>
@endpush
