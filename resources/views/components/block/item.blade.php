@php
    $content = $block->content ?? [];
    $type    = $block->type;
@endphp

<div class="block-item group/block relative flex items-start gap-1 py-1 -mx-4 px-4 hover:bg-surface-100 dark:hover:bg-dark-surface2 transition-colors rounded-lg"
     data-block-id="{{ $block->id }}"
     data-block-type="{{ $type }}"
     id="block-{{ $block->id }}">

    {{-- Drag handle + delete (visible on hover) --}}
    <div class="block-controls absolute right-full mr-1 top-1.5 opacity-0 group-hover/block:opacity-100 transition-opacity flex items-center gap-1">
        <button type="button" class="block-delete-btn p-1 text-text-muted hover:text-red-500 dark:text-text-darkMuted dark:hover:text-red-400 rounded transition-colors"
                data-block-id="{{ $block->id }}"
                title="Hapus block"
                aria-label="Hapus block">
            <i class="bi bi-trash3 text-sm"></i>
        </button>
        <span class="block-drag-handle cursor-grab active:cursor-grabbing p-1 text-text-muted hover:text-text-main dark:text-text-darkMuted dark:hover:text-text-darkMain rounded transition-colors" title="Drag untuk mengubah urutan">
            <i class="bi bi-grip-vertical text-sm"></i>
        </span>
    </div>

    {{-- Block content based on type --}}
    @if($type === 'divider')
        <div class="flex-1 py-3">
            <hr class="border-t border-surface-500 dark:border-dark-border">
        </div>

    @elseif($type === 'todo')
        <div class="flex-1 flex items-start gap-3 py-1 group/todo">
            <input type="checkbox"
                   class="block-todo-checkbox mt-1.5 w-4 h-4 text-primary bg-surface-200 border-surface-500 rounded focus:ring-primary dark:bg-dark-surface dark:border-dark-border dark:checked:bg-primary accent-primary cursor-pointer transition-colors"
                   {{ ($content['checked'] ?? false) ? 'checked' : '' }}
                   data-block-id="{{ $block->id }}"
                   aria-label="Toggle todo">
            <div class="block-content flex-1 text-text-main dark:text-text-darkMain outline-none min-h-[24px] {{ ($content['checked'] ?? false) ? 'line-through text-text-muted dark:text-text-darkMuted' : '' }} transition-colors"
                 contenteditable="true"
                 data-block-id="{{ $block->id }}"
                 data-field="text"
                 data-placeholder="Tambahkan item todo…">{!! nl2br(e($content['text'] ?? '')) !!}</div>
        </div>

    @elseif($type === 'heading')
        @php $level = $content['level'] ?? 2; @endphp
        <div class="flex-1 relative group/heading mt-4 mb-1">
            <select class="block-heading-level-select absolute right-0 top-0 opacity-0 group-hover/heading:opacity-100 transition-opacity bg-transparent border-none text-[10px] text-text-muted dark:text-text-darkMuted cursor-pointer outline-none"
                    data-block-id="{{ $block->id }}">
                <option value="1" {{ $level == 1 ? 'selected' : '' }}>H1</option>
                <option value="2" {{ $level == 2 ? 'selected' : '' }}>H2</option>
                <option value="3" {{ $level == 3 ? 'selected' : '' }}>H3</option>
            </select>
            <div class="block-content text-text-main dark:text-text-darkMain outline-none font-bold {{ $level == 1 ? 'text-3xl mt-6' : ($level == 2 ? 'text-2xl mt-4' : 'text-xl mt-2') }}"
                 contenteditable="true"
                 data-block-id="{{ $block->id }}"
                 data-field="text"
                 data-placeholder="Heading {{ $level }}…">{!! nl2br(e($content['text'] ?? '')) !!}</div>
        </div>

    @elseif($type === 'table')
        <div class="block-table-wrapper flex-1 my-2 overflow-x-auto">
            <table class="block-table-editor w-full border-collapse min-w-[300px]" data-block-id="{{ $block->id }}">
                <thead>
                    <tr>
                        @foreach($content['headers'] ?? ['Kolom 1', 'Kolom 2'] as $header)
                            <th contenteditable="true" data-block-id="{{ $block->id }}" data-is-table="1" class="border border-surface-500 dark:border-dark-border bg-surface-100 dark:bg-dark-surface2 px-3 py-2 text-sm font-semibold text-text-main dark:text-text-darkMain text-left outline-none focus:bg-surface-200 dark:focus:bg-dark-surface min-w-[100px]">{!! e($header) !!}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($content['rows'] ?? [['', '']] as $row)
                        <tr>
                            @foreach($row as $cell)
                                <td contenteditable="true" data-block-id="{{ $block->id }}" data-is-table="1" class="border border-surface-500 dark:border-dark-border px-3 py-2 text-sm text-text-main dark:text-text-darkMain outline-none focus:bg-surface-100 dark:focus:bg-dark-bg">{!! e($cell) !!}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-2 flex gap-2 opacity-0 group-hover/block:opacity-100 transition-opacity">
                <button class="btn-planova btn-ghost-p btn-sm-p table-add-row" data-block-id="{{ $block->id }}" type="button">
                    <i class="bi bi-plus"></i> Baris
                </button>
                <button class="btn-planova btn-ghost-p btn-sm-p table-add-col" data-block-id="{{ $block->id }}" type="button">
                    <i class="bi bi-plus"></i> Kolom
                </button>
            </div>
        </div>

    @elseif($type === 'bullet_list')
        <div class="flex-1 flex items-start gap-2 py-0.5">
            <div class="mt-2.5 w-1.5 h-1.5 rounded-full bg-text-main dark:bg-text-darkMain shrink-0"></div>
            <div class="block-content flex-1 text-text-main dark:text-text-darkMain outline-none min-h-[24px]"
                 contenteditable="true"
                 data-block-id="{{ $block->id }}"
                 data-field="text"
                 data-placeholder="List item…">{!! nl2br(e($content['text'] ?? '')) !!}</div>
        </div>

    @else {{-- text --}}
        <div class="block-content flex-1 text-text-main dark:text-text-darkMain outline-none min-h-[24px] py-1 leading-relaxed"
             contenteditable="true"
             data-block-id="{{ $block->id }}"
             data-field="text"
             data-placeholder="Tulis sesuatu, atau ketik '/' untuk commands…">{!! nl2br(e($content['text'] ?? '')) !!}</div>
    @endif

</div>
