@extends('layouts.app')

@section('title', $task->title)

@php
    $breadcrumbs = [
        ['label' => 'Tasks', 'url' => route('tasks.index')],
        ['label' => $task->title],
    ];
    $typeIcons = [
        'select'   => 'bi-list-check',
        'status'   => 'bi-circle-half',
        'text'     => 'bi-fonts',
        'date'     => 'bi-calendar3',
        'checkbox' => 'bi-check2-square',
        'number'   => 'bi-hash',
        'url'      => 'bi-link-45deg',
        'email'    => 'bi-envelope',
        'phone'    => 'bi-telephone',
        'person'   => 'bi-person',
    ];
@endphp

@section('content')
<div class="max-w-5xl mx-auto">

{{-- ── Task Header ───────────────────────────────────────── --}}
<div class="flex flex-col md:flex-row justify-between items-start gap-4 mb-6">
    <div class="flex-1 min-w-0">
        <div class="flex items-center gap-2 mb-3 flex-wrap">
            <span class="badge-p {{ $task->status_badge_class }}">{{ $task->status_label }}</span>
            @if($task->due_date)
                <span class="text-xs font-medium {{ $task->is_overdue ? 'text-red-600' : 'text-text-secondary' }} bg-surface-200 px-2 py-0.5 rounded-full flex items-center gap-1">
                    <i class="bi bi-calendar3"></i> {{ $task->due_date->format('d M Y') }}
                    @if($task->is_overdue)<span class="text-red-600 ml-1">(Overdue)</span>@endif
                </span>
            @endif
        </div>
        <h1 class="text-3xl font-bold text-text-main leading-tight mb-2 break-words">{{ $task->title }}</h1>
        @if($task->description)
            <p class="text-base text-text-secondary break-words">{{ $task->description }}</p>
        @endif
    </div>
    <div class="flex items-center gap-2 shrink-0">
        <a href="{{ route('tasks.edit', $task) }}" class="btn-planova btn-secondary-p">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Hapus task ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-planova btn-danger-p"><i class="bi bi-trash"></i> Hapus</button>
        </form>
    </div>
</div>

{{-- ── Properties Table ──────────────────────────────────── --}}
<div class="bg-white/80 backdrop-blur-sm border border-surface-500 rounded-2xl overflow-hidden mb-6 animate-fade-in"
     style="box-shadow:4px 4px 16px rgba(13,148,136,0.06);">
    <div class="overflow-x-auto">
        <table class="w-full border-collapse" id="prop-table">
            <thead>
                <tr class="border-b border-surface-500 bg-teal-50/40">
                    <th class="px-4 py-3 text-left min-w-[200px]">
                        <span class="text-xs font-bold text-text-muted uppercase tracking-wider flex items-center gap-1.5">
                            <i class="bi bi-card-text text-xs"></i>Nama Tugas
                        </span>
                    </th>
                    <th class="px-4 py-3 text-left w-36">
                        <span class="text-xs font-bold text-text-muted uppercase tracking-wider flex items-center gap-1.5">
                            <i class="bi bi-circle-half text-xs"></i>Status
                        </span>
                    </th>
                    <th class="px-4 py-3 text-left w-28">
                        <span class="text-xs font-bold text-text-muted uppercase tracking-wider flex items-center gap-1.5">
                            <i class="bi bi-flag text-xs"></i>Prioritas
                        </span>
                    </th>
                    <th class="px-4 py-3 text-left w-36">
                        <span class="text-xs font-bold text-text-muted uppercase tracking-wider flex items-center gap-1.5">
                            <i class="bi bi-calendar3 text-xs"></i>Tenggat Waktu
                        </span>
                    </th>
                    @foreach($properties as $prop)
                    <th class="prop-col-header px-4 py-3 text-left w-36 group cursor-pointer select-none"
                        data-property-id="{{ $prop->id }}"
                        data-property-name="{{ $prop->name }}"
                        data-property-type="{{ $prop->type }}"
                        data-property-config="{{ json_encode($prop->config) }}">
                        <span class="text-xs font-bold text-text-muted uppercase tracking-wider flex items-center gap-1.5 hover:text-primary transition-colors">
                            <i class="bi {{ $typeIcons[$prop->type] ?? 'bi-tag' }} text-xs shrink-0"></i>
                            <span class="prop-col-name truncate">{{ $prop->name }}</span>
                            <svg class="w-3 h-3 shrink-0 opacity-0 group-hover:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                        </span>
                    </th>
                    @endforeach
                    {{-- + Add property --}}
                    <th class="px-3 py-3 w-10">
                        <button type="button" id="prop-add-new-btn" title="Tambah properti"
                                class="w-6 h-6 flex items-center justify-center rounded-lg text-text-muted hover:text-primary hover:bg-teal-100 transition-colors cursor-pointer">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        </button>
                    </th>
                    {{-- ... options --}}
                    <th class="px-2 py-3 w-8">
                        <button type="button" title="Table options"
                                class="w-6 h-6 flex items-center justify-center rounded-lg text-text-muted hover:text-primary hover:bg-teal-100 transition-colors cursor-pointer">
                            <i class="bi bi-three-dots text-sm"></i>
                        </button>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr id="prop-data-row" class="hover:bg-teal-50/20 transition-colors">
                    <td class="px-4 py-3">
                        <span class="text-sm font-semibold text-text-main truncate block max-w-[220px]">{{ $task->title }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <button type="button" class="status-cell-trigger cursor-pointer" data-task-status="{{ $task->status }}">
                            <span class="badge-p {{ $task->status_badge_class }}">{{ $task->status_label }}</span>
                        </button>
                    </td>
                    <td class="px-4 py-3">
                        @php
                            $pm = [0=>['label'=>'Normal','class'=>'badge-todo'],1=>['label'=>'Tinggi','class'=>'badge-progress'],2=>['label'=>'Urgent','class'=>'badge-expense']];
                            $p = $pm[$task->priority] ?? $pm[0];
                        @endphp
                        <span class="badge-p {{ $p['class'] }}">{{ $p['label'] }}</span>
                    </td>
                    <td class="px-4 py-3">
                        @if($task->due_date)
                            <span class="text-xs font-medium {{ $task->is_overdue?'text-red-600':'text-text-secondary' }}">{{ $task->due_date->format('d M Y') }}</span>
                        @else
                            <span class="text-xs text-text-muted">—</span>
                        @endif
                    </td>
                    @foreach($properties as $prop)
                    @php $val=$valueMap->get($prop->id); $rawValue=$val?$val->value:null; @endphp
                    <td class="prop-value-cell px-4 py-3" data-property-id="{{ $prop->id }}" data-property-type="{{ $prop->type }}">
                        @if($prop->type === 'select' || $prop->type === 'status')
                            @php $opt=$rawValue?$prop->findOption($rawValue):null; @endphp
                            <button type="button" class="prop-select-trigger cursor-pointer"
                                    data-property-id="{{ $prop->id }}"
                                    data-property-type="{{ $prop->type }}"
                                    data-current-value="{{ $rawValue??'' }}">
                                @if($opt)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold text-white" style="background-color:{{ $opt['color']??'#6b7280' }};">
                                        <span class="w-1.5 h-1.5 rounded-full bg-white/40 shrink-0"></span>{{ $opt['label'] }}
                                    </span>
                                @else
                                    <span class="text-xs text-text-muted italic">— pilih</span>
                                @endif
                            </button>
                        @elseif($prop->type==='checkbox')
                            <button type="button" class="prop-checkbox-trigger cursor-pointer flex items-center"
                                    data-property-id="{{ $prop->id }}" data-current-value="{{ $rawValue??'0' }}">
                                @if($rawValue==='1')
                                    <svg class="w-5 h-5 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                                @else
                                    <svg class="w-5 h-5 text-text-muted" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
                                @endif
                            </button>
                        @elseif($prop->type==='date')
                            <input type="date" class="prop-date-input text-xs font-medium text-text-main bg-transparent border-none outline-none cursor-pointer w-full"
                                   data-property-id="{{ $prop->id }}" value="{{ $rawValue??'' }}">
                        @else
                            <input type="{{ $prop->type==='url'?'url':($prop->type==='number'?'number':'text') }}"
                                   class="prop-text-input text-xs font-medium text-text-main bg-transparent border-none outline-none w-full focus:outline-none"
                                   data-property-id="{{ $prop->id }}" value="{{ $rawValue??'' }}" placeholder="—" autocomplete="off">
                        @endif
                    </td>
                    @endforeach
                    <td class="px-3 py-3"></td><td class="px-2 py-3"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- ── Block Editor (Quill) ──────────────────────────────── --}}
<div class="animate-fade-in">
    <div class="flex items-center justify-between mb-3 px-2">
        <span class="text-sm font-semibold text-text-secondary flex items-center gap-2 uppercase tracking-wide">
            <i class="bi bi-file-text"></i>Konten
        </span>
        <div id="block-saving" class="text-sm text-green-600 font-medium flex items-center gap-1 opacity-0 transition-opacity">
            <i class="bi bi-cloud-check"></i>Tersimpan
        </div>
    </div>

    {{-- Quill toolbar + editor wrapper --}}
    <div class="bg-surface-200 border border-surface-500 rounded-2xl overflow-hidden shadow-sm">

        {{-- Custom toolbar (kita kontrol sendiri, bukan Quill toolbar) --}}
        <div id="rte-toolbar" class="border-b border-surface-500 bg-white/70 px-3 py-2 flex flex-wrap items-center gap-1">

            {{-- Font family dropdown --}}
            <select id="rte-font" title="Font family"
                    class="h-7 text-xs bg-white border border-surface-500 rounded-lg px-2 text-text-secondary cursor-pointer focus:outline-none focus:border-primary"
                    style="min-width:140px;">
                <option value="times-new-roman">Times New Roman</option>
                <option value="arial">Arial</option>
                <option value="helvetica">Helvetica</option>
                <option value="georgia">Georgia</option>
                <option value="courier-new">Courier New</option>
                <option value="verdana">Verdana</option>
                <option value="trebuchet-ms">Trebuchet MS</option>
                <option value="palatino">Palatino</option>
                <option value="garamond">Garamond</option>
                <option value="comic-sans">Comic Sans MS</option>
                <option value="impact">Impact</option>
                <option value="tahoma">Tahoma</option>
            </select>

            {{-- Font size --}}
            <select id="rte-size" title="Font size"
                    class="h-7 text-xs bg-white border border-surface-500 rounded-lg px-2 text-text-secondary cursor-pointer focus:outline-none focus:border-primary"
                    style="width:58px;">
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12" selected>12</option>
                <option value="14">14</option>
                <option value="16">16</option>
                <option value="18">18</option>
                <option value="20">20</option>
                <option value="24">24</option>
                <option value="28">28</option>
                <option value="32">32</option>
                <option value="36">36</option>
                <option value="48">48</option>
                <option value="72">72</option>
            </select>

            <div class="w-px h-5 bg-surface-500 mx-0.5"></div>

            {{-- Format buttons --}}
            @foreach([
                ['cmd'=>'bold',        'icon'=>'bi-type-bold',          'title'=>'Bold (Ctrl+B)'],
                ['cmd'=>'italic',      'icon'=>'bi-type-italic',        'title'=>'Italic (Ctrl+I)'],
                ['cmd'=>'underline',   'icon'=>'bi-type-underline',     'title'=>'Underline (Ctrl+U)'],
                ['cmd'=>'strike',      'icon'=>'bi-type-strikethrough', 'title'=>'Strikethrough'],
            ] as $f)
            <button type="button" data-fmt="{{ $f['cmd'] }}" title="{{ $f['title'] }}"
                    class="rte-fmt-btn w-7 h-7 flex items-center justify-center rounded-lg text-text-secondary hover:text-text-main hover:bg-surface-300 transition-colors cursor-pointer">
                <i class="bi {{ $f['icon'] }} text-sm"></i>
            </button>
            @endforeach

            {{-- Sub / Super --}}
            <button type="button" data-fmt="script" data-val="sub" title="Subscript"
                    class="rte-fmt-btn w-7 h-7 flex items-center justify-center rounded-lg text-text-secondary hover:text-text-main hover:bg-surface-300 transition-colors cursor-pointer">
                <i class="bi bi-subscript text-sm"></i>
            </button>
            <button type="button" data-fmt="script" data-val="super" title="Superscript"
                    class="rte-fmt-btn w-7 h-7 flex items-center justify-center rounded-lg text-text-secondary hover:text-text-main hover:bg-surface-300 transition-colors cursor-pointer">
                <i class="bi bi-superscript text-sm"></i>
            </button>

            <div class="w-px h-5 bg-surface-500 mx-0.5"></div>

            {{-- Text color --}}
            <div class="relative flex items-center">
                <button type="button" id="rte-color-btn" title="Text color"
                        class="w-7 h-7 flex flex-col items-center justify-center rounded-lg text-text-secondary hover:text-text-main hover:bg-surface-300 transition-colors cursor-pointer gap-0.5">
                    <i class="bi bi-type text-sm leading-none"></i>
                    <div id="rte-color-bar" class="w-4 h-1 rounded-full" style="background:#000;"></div>
                </button>
                <input type="color" id="rte-color-input" class="absolute opacity-0 w-0 h-0 pointer-events-none" value="#000000">
            </div>

            {{-- Highlight color --}}
            <div class="relative flex items-center">
                <button type="button" id="rte-bg-btn" title="Highlight color"
                        class="w-7 h-7 flex flex-col items-center justify-center rounded-lg text-text-secondary hover:text-text-main hover:bg-surface-300 transition-colors cursor-pointer gap-0.5">
                    <i class="bi bi-highlighter text-sm leading-none"></i>
                    <div id="rte-bg-bar" class="w-4 h-1 rounded-full" style="background:#ffff00;"></div>
                </button>
                <input type="color" id="rte-bg-input" class="absolute opacity-0 w-0 h-0 pointer-events-none" value="#ffff00">
            </div>

            <div class="w-px h-5 bg-surface-500 mx-0.5"></div>

            {{-- Alignment --}}
            @foreach([
                ['val'=>false,     'icon'=>'bi-text-left',   'title'=>'Align left'],
                ['val'=>'center',  'icon'=>'bi-text-center', 'title'=>'Align center'],
                ['val'=>'right',   'icon'=>'bi-text-right',  'title'=>'Align right'],
                ['val'=>'justify', 'icon'=>'bi-justify',     'title'=>'Justify'],
            ] as $a)
            <button type="button" data-fmt="align" data-val="{{ $a['val'] === false ? '' : $a['val'] }}" title="{{ $a['title'] }}"
                    class="rte-fmt-btn w-7 h-7 flex items-center justify-center rounded-lg text-text-secondary hover:text-text-main hover:bg-surface-300 transition-colors cursor-pointer">
                <i class="bi {{ $a['icon'] }} text-sm"></i>
            </button>
            @endforeach

            <div class="w-px h-5 bg-surface-500 mx-0.5"></div>

            {{-- Lists --}}
            <button type="button" data-fmt="list" data-val="ordered" title="Numbered list"
                    class="rte-fmt-btn w-7 h-7 flex items-center justify-center rounded-lg text-text-secondary hover:text-text-main hover:bg-surface-300 transition-colors cursor-pointer">
                <i class="bi bi-list-ol text-sm"></i>
            </button>
            <button type="button" data-fmt="list" data-val="bullet" title="Bullet list"
                    class="rte-fmt-btn w-7 h-7 flex items-center justify-center rounded-lg text-text-secondary hover:text-text-main hover:bg-surface-300 transition-colors cursor-pointer">
                <i class="bi bi-list-ul text-sm"></i>
            </button>

            {{-- Indent --}}
            <button type="button" data-fmt="indent" data-val="-1" title="Outdent"
                    class="rte-fmt-btn w-7 h-7 flex items-center justify-center rounded-lg text-text-secondary hover:text-text-main hover:bg-surface-300 transition-colors cursor-pointer">
                <i class="bi bi-text-indent-right text-sm"></i>
            </button>
            <button type="button" data-fmt="indent" data-val="+1" title="Indent"
                    class="rte-fmt-btn w-7 h-7 flex items-center justify-center rounded-lg text-text-secondary hover:text-text-main hover:bg-surface-300 transition-colors cursor-pointer">
                <i class="bi bi-text-indent-left text-sm"></i>
            </button>

            <div class="w-px h-5 bg-surface-500 mx-0.5"></div>

            {{-- Link, blockquote, code, clear --}}
            <button type="button" data-fmt="link" title="Insert link"
                    class="rte-fmt-btn w-7 h-7 flex items-center justify-center rounded-lg text-text-secondary hover:text-text-main hover:bg-surface-300 transition-colors cursor-pointer">
                <i class="bi bi-link-45deg text-sm"></i>
            </button>
            <button type="button" data-fmt="blockquote" title="Blockquote"
                    class="rte-fmt-btn w-7 h-7 flex items-center justify-center rounded-lg text-text-secondary hover:text-text-main hover:bg-surface-300 transition-colors cursor-pointer">
                <i class="bi bi-quote text-sm"></i>
            </button>
            <button type="button" data-fmt="code-block" title="Code block"
                    class="rte-fmt-btn w-7 h-7 flex items-center justify-center rounded-lg text-text-secondary hover:text-text-main hover:bg-surface-300 transition-colors cursor-pointer">
                <i class="bi bi-code-slash text-sm"></i>
            </button>
            <button type="button" id="rte-clear" title="Clear formatting"
                    class="w-7 h-7 flex items-center justify-center rounded-lg text-text-secondary hover:text-text-main hover:bg-surface-300 transition-colors cursor-pointer">
                <i class="bi bi-eraser text-sm"></i>
            </button>
        </div>

        {{-- Quill editor container --}}
        <div id="quill-editor" class="px-6 py-5 min-h-[360px]"></div>
    </div>

    {{-- Hidden legacy block list (kept for block CRUD compatibility, hidden visually) --}}
    <div id="block-list" data-blockable-type="App\Models\Task" data-blockable-id="{{ $task->id }}" class="hidden">
        @foreach($task->blocks as $block)
            @include('components.block.item', ['block' => $block])
        @endforeach
    </div>
</div>

</div>{{-- /max-w-5xl --}}

{{-- ══════════════════════════════════════════════════════════
     DARK POPUPS
     ══════════════════════════════════════════════════════════ --}}

{{-- ── Status Grouped Dropdown ────────────────────────────── --}}
<div id="status-dropdown"
     class="dark-popup fixed z-[60] hidden w-60 rounded-xl py-2 overflow-hidden"
     style="background:#1e293b;border:1px solid rgba(255,255,255,0.1);box-shadow:0 16px 48px rgba(0,0,0,0.5);">
    {{-- Active value display --}}
    <div id="status-active-row" class="px-3 py-2 flex items-center justify-between border-b border-white/10 mb-1">
        <span id="status-active-badge" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold text-white">
            <span class="w-1.5 h-1.5 rounded-full bg-white/40 shrink-0"></span>—
        </span>
        <input id="status-active-rename" type="text" maxlength="60"
               class="hidden ml-2 flex-1 bg-transparent text-white text-xs outline-none border-b border-white/30"
               placeholder="Rename…">
    </div>
    {{-- Groups filled by JS --}}
    <div id="status-groups" class="max-h-64 overflow-y-auto px-1"></div>
    {{-- Edit property link --}}
    <div class="border-t border-white/10 mt-1 pt-1 px-2">
        <button type="button" id="status-edit-prop-btn"
                class="w-full flex items-center gap-2 px-2 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-white/10 transition-colors cursor-pointer">
            <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            Edit property
        </button>
    </div>
</div>

{{-- ── Select Dropdown (with search + create + drag) ─────── --}}
<div id="select-dropdown"
     class="dark-popup fixed z-[60] hidden w-64 rounded-xl py-2 overflow-hidden"
     style="background:#1e293b;border:1px solid rgba(255,255,255,0.1);box-shadow:0 16px 48px rgba(0,0,0,0.5);">
    {{-- Active tag header --}}
    <div id="select-active-header" class="px-3 pb-2 border-b border-white/10 min-h-[36px] flex flex-wrap gap-1 items-center"></div>
    {{-- Search / create --}}
    <div class="px-3 pt-2 pb-1">
        <input id="select-search-input" type="text" maxlength="80"
               placeholder="Select an option or create one"
               class="w-full bg-white/10 rounded-lg px-3 py-1.5 text-xs text-white placeholder-slate-400 outline-none border border-white/10 focus:border-white/30 transition-colors">
    </div>
    {{-- Options list --}}
    <div id="select-options-list" class="max-h-52 overflow-y-auto px-2 py-1 space-y-0.5"></div>
    {{-- Create hint --}}
    <div id="select-create-hint" class="hidden px-3 py-1.5 border-t border-white/10">
        <button type="button" id="select-create-btn"
                class="w-full flex items-center gap-2 px-2 py-1.5 rounded-lg text-xs font-semibold text-slate-300 hover:text-white hover:bg-white/10 transition-colors cursor-pointer">
            <svg class="w-3.5 h-3.5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Create <strong id="select-create-label" class="text-white ml-1"></strong>
        </button>
    </div>
</div>

{{-- ── Edit Option Sub-popup ───────────────────────────────── --}}
<div id="edit-option-popup"
     class="dark-popup fixed z-[65] hidden w-52 rounded-xl py-2"
     style="background:#1e293b;border:1px solid rgba(255,255,255,0.1);box-shadow:0 16px 48px rgba(0,0,0,0.5);">
    <div class="px-3 pb-2 border-b border-white/10">
        <input id="edit-option-name" type="text" maxlength="80"
               class="w-full bg-white/10 rounded-lg px-3 py-1.5 text-xs text-white outline-none border border-white/10 focus:border-white/30 transition-colors"
               placeholder="Option name">
    </div>
    <div class="px-2 pt-1">
        <button type="button" id="edit-option-delete"
                class="w-full flex items-center gap-2 px-2 py-1.5 rounded-lg text-xs font-semibold text-red-400 hover:text-red-300 hover:bg-white/10 transition-colors cursor-pointer">
            <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
            Delete
        </button>
    </div>
    <div class="px-3 pt-2 border-t border-white/10">
        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Colors</p>
        <div id="edit-option-colors" class="grid grid-cols-5 gap-1.5">
            @foreach([
                ['color'=>'#94a3b8','label'=>'Default'],
                ['color'=>'#6b7280','label'=>'Gray'],
                ['color'=>'#92400e','label'=>'Brown'],
                ['color'=>'#f97316','label'=>'Orange'],
                ['color'=>'#eab308','label'=>'Yellow'],
                ['color'=>'#22c55e','label'=>'Green'],
                ['color'=>'#3b82f6','label'=>'Blue'],
                ['color'=>'#8b5cf6','label'=>'Purple'],
                ['color'=>'#ec4899','label'=>'Pink'],
                ['color'=>'#ef4444','label'=>'Red'],
            ] as $c)
            <button type="button" class="edit-opt-color-swatch w-7 h-7 rounded-lg cursor-pointer hover:scale-110 transition-transform relative flex items-center justify-center border-2 border-transparent"
                    data-color="{{ $c['color'] }}" title="{{ $c['label'] }}"
                    style="background-color:{{ $c['color'] }};">
                <svg class="check-icon hidden w-3.5 h-3.5 text-white drop-shadow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
            </button>
            @endforeach
        </div>
    </div>
</div>

{{-- ── Add Property Popup ──────────────────────────────────── --}}
<div id="add-prop-popup"
     class="dark-popup fixed z-[60] hidden w-72 rounded-xl overflow-hidden"
     style="background:#1e293b;border:1px solid rgba(255,255,255,0.1);box-shadow:0 16px 48px rgba(0,0,0,0.5);">
    {{-- Name input --}}
    <div class="px-3 pt-3 pb-2 border-b border-white/10">
        <input id="new-prop-name-input" type="text" maxlength="100"
               placeholder="Type property name..."
               class="w-full bg-white/10 rounded-lg px-3 py-2 text-sm text-white placeholder-slate-400 outline-none border border-white/10 focus:border-white/30 transition-colors">
    </div>
    {{-- AI Autofill --}}
    <div class="px-3 py-2 border-b border-white/10">
        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">AI Autofill</p>
        <div class="flex gap-2">
            <button type="button" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/10 text-xs text-slate-300 hover:text-white hover:bg-white/15 transition-colors cursor-pointer border border-white/10">
                <i class="bi bi-stars text-amber-400"></i> Summarize
            </button>
            <button type="button" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/10 text-xs text-slate-300 hover:text-white hover:bg-white/15 transition-colors cursor-pointer border border-white/10">
                <i class="bi bi-translate text-blue-400"></i> Translate
            </button>
        </div>
    </div>
    {{-- Type search --}}
    <div class="px-3 pt-2 pb-1">
        <input id="prop-type-search" type="text" placeholder="Search type..."
               class="w-full bg-white/10 rounded-lg px-3 py-1.5 text-xs text-white placeholder-slate-400 outline-none border border-white/10 focus:border-white/30 transition-colors">
    </div>
    {{-- Type grid --}}
    <div id="prop-type-grid" class="px-3 pb-3 grid grid-cols-2 gap-1 max-h-64 overflow-y-auto">
        @foreach([
            ['type'=>'text',          'icon'=>'bi-fonts',         'label'=>'Text'],
            ['type'=>'number',        'icon'=>'bi-hash',          'label'=>'Number'],
            ['type'=>'select',        'icon'=>'bi-list-check',    'label'=>'Select'],
            ['type'=>'multi_select',  'icon'=>'bi-tags',          'label'=>'Multi-select'],
            ['type'=>'status',        'icon'=>'bi-circle-half',   'label'=>'Status'],
            ['type'=>'date',          'icon'=>'bi-calendar3',     'label'=>'Date'],
            ['type'=>'person',        'icon'=>'bi-person',        'label'=>'Person'],
            ['type'=>'checkbox',      'icon'=>'bi-check2-square', 'label'=>'Checkbox'],
            ['type'=>'url',           'icon'=>'bi-link-45deg',    'label'=>'URL'],
            ['type'=>'email',         'icon'=>'bi-envelope',      'label'=>'Email'],
            ['type'=>'phone',         'icon'=>'bi-telephone',     'label'=>'Phone'],
            ['type'=>'formula',       'icon'=>'bi-braces',        'label'=>'Formula'],
        ] as $pt)
        <button type="button"
                class="prop-type-pick flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-slate-300 hover:text-white hover:bg-white/10 transition-colors cursor-pointer text-left"
                data-type="{{ $pt['type'] }}">
            <i class="bi {{ $pt['icon'] }} text-sm w-4 text-center shrink-0 text-slate-400"></i>
            <span class="font-medium">{{ $pt['label'] }}</span>
        </button>
        @endforeach
    </div>
</div>

{{-- ── Edit Property Panel (dark slide-in) ────────────────── --}}
@include('components.task-property-panel')

@endsection

@push('head')
{{-- Quill CSS --}}
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
{{-- Google Fonts for editor --}}
<link href="https://fonts.googleapis.com/css2?family=Comic+Sans+MS&family=Georgia&family=Impact&family=Palatino+Linotype&family=Tahoma&family=Trebuchet+MS&family=Verdana&display=swap" rel="stylesheet">
<style>
    /* Remove ALL Quill chrome — we use our own toolbar */
    .ql-toolbar.ql-snow { display:none !important; }
    .ql-container.ql-snow { border:none !important; }
    .ql-editor {
        min-height: 360px;
        padding: 20px 24px;
        font-family: 'Times New Roman', serif;
        font-size: 12pt;
        line-height: 1.7;
        color: #134E4A;
    }
    .ql-editor p { margin-bottom: 0.4em; }
    .ql-editor:focus { outline: none; }

    /* Active state for toolbar buttons */
    .rte-fmt-btn.is-active {
        background: rgba(13,148,136,0.12);
        color: #0d9488;
    }

    /* Font family classes Quill will apply */
    .ql-font-times-new-roman  { font-family: 'Times New Roman', serif !important; }
    .ql-font-arial            { font-family: Arial, sans-serif !important; }
    .ql-font-helvetica        { font-family: Helvetica, Arial, sans-serif !important; }
    .ql-font-georgia          { font-family: Georgia, serif !important; }
    .ql-font-courier-new      { font-family: 'Courier New', monospace !important; }
    .ql-font-verdana          { font-family: Verdana, Geneva, sans-serif !important; }
    .ql-font-trebuchet-ms     { font-family: 'Trebuchet MS', sans-serif !important; }
    .ql-font-palatino         { font-family: 'Palatino Linotype', Palatino, serif !important; }
    .ql-font-garamond         { font-family: Garamond, 'EB Garamond', serif !important; }
    .ql-font-comic-sans       { font-family: 'Comic Sans MS', cursive !important; }
    .ql-font-impact           { font-family: Impact, Charcoal, sans-serif !important; }
    .ql-font-tahoma           { font-family: Tahoma, Geneva, sans-serif !important; }

    /* Dark popup shared reset */
    .dark-popup * { box-sizing: border-box; }

    /* Quill editor scrollbar */
    .ql-editor::-webkit-scrollbar { width: 4px; }
    .ql-editor::-webkit-scrollbar-thumb { background: rgba(13,148,136,0.2); border-radius: 2px; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.3/Sortable.min.js"></script>
<script>
    window.PLANOVA = window.PLANOVA || {};
    window.PLANOVA.blockRoutes = {
        store:   '{{ route('blocks.store') }}',
        update:  '{{ url('blocks') }}',
        destroy: '{{ url('blocks') }}',
        reorder: '{{ route('blocks.reorder') }}',
    };
    window.PLANOVA.blockable = { type: 'App\\Models\\Task', id: {{ $task->id }} };
    window.PLANOVA.propRoutes = {
        index:   '{{ route('task-properties.index') }}',
        store:   '{{ route('task-properties.store') }}',
        update:  '{{ url('task-properties') }}',
        destroy: '{{ url('task-properties') }}',
        reorder: '{{ route('task-properties.reorder') }}',
        values:  '{{ url('task-properties') }}',
    };
    window.PLANOVA.taskId = {{ $task->id }};

    // Seed initial block content for Quill from existing blocks
    window.PLANOVA.initialBlocks = @json($task->blocks->map(fn($b) => ['type'=>$b->type,'content'=>$b->content,'id'=>$b->id])->values());
</script>
<script src="{{ asset('js/block-editor.js') }}"></script>
<script src="{{ asset('js/task-properties.js') }}"></script>
@endpush
