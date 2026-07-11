@extends('layouts.app')

@section('title', 'Tasks')
@section('page_title', 'Tasks')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-text-main dark:text-text-darkMain mb-1">Tasks</h1>
        <p class="text-sm text-text-muted dark:text-text-darkMuted">Kelola dan pantau semua tugas Anda.</p>
    </div>
    <a href="{{ route('tasks.create') }}" class="btn-planova btn-primary-p shrink-0">
        <i class="bi bi-plus-lg"></i> Task Baru
    </a>
</div>

{{-- ── Filter Bar ──────────────────────────────────────── --}}
<div class="flex flex-wrap items-center gap-2 mb-6">
    @foreach([''=>'Semua', 'todo'=>'Todo', 'in_progress'=>'In Progress', 'done'=>'Selesai'] as $val => $label)
        <a href="{{ route('tasks.index', $val ? ['status' => $val] : []) }}"
           class="btn-planova {{ $status === $val ? 'btn-primary-p' : 'btn-secondary-p' }} btn-sm-p transition-all">
            {{ $label }}
            @if($val === '' )
                <span class="ml-1.5 px-1.5 py-0.5 rounded-full text-[10px] font-bold {{ $status === '' ? 'bg-white/20' : 'bg-surface-300 dark:bg-dark-border' }}">{{ $tasks->count() }}</span>
            @endif
        </a>
    @endforeach
</div>

{{-- ── Tasks List ──────────────────────────────────────── --}}
<div class="pcard p-0 overflow-hidden">

    @if($tasks->isEmpty())
        <div class="text-center py-16 px-6">
            <div class="text-5xl text-surface-500 dark:text-dark-border mb-4">📋</div>
            <div class="text-lg font-semibold text-text-main dark:text-text-darkMain mb-2">
                @if($status) Tidak ada task dengan status "{{ $status }}"
                @else Belum ada task
                @endif
            </div>
            <p class="text-sm text-text-muted dark:text-text-darkMuted mb-6 max-w-sm mx-auto">Buat task baru untuk mulai melacak produktivitas Anda.</p>
            <a href="{{ route('tasks.create') }}" class="btn-planova btn-primary-p">
                <i class="bi bi-plus-lg"></i> Buat Task Pertama
            </a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="ptable min-w-[600px]">
                <thead>
                    <tr>
                        <th class="w-1/2">Judul</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Dibuat</th>
                        <th class="w-24 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-500 dark:divide-dark-border">
                    @foreach($tasks as $task)
                    <tr class="animate-stagger-card opacity-0 group">
                        <td>
                            <a href="{{ route('tasks.show', $task) }}" class="text-sm font-medium text-text-main dark:text-text-darkMain hover:text-primary dark:hover:text-primary-light transition-colors block">
                                {{ $task->title }}
                            </a>
                            @if($task->description)
                                <div class="text-xs text-text-muted dark:text-text-darkMuted mt-1 truncate max-w-sm">
                                    {{ Str::limit($task->description, 60) }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="badge-p {{ $task->status_badge_class }}">{{ $task->status_label }}</span>
                        </td>
                        <td>
                            @if($task->due_date)
                                <span class="text-xs font-medium {{ $task->is_overdue ? 'text-red-600 dark:text-red-400' : 'text-text-secondary dark:text-text-darkSecondary' }}">
                                    @if($task->is_overdue)<i class="bi bi-exclamation-circle mr-1"></i>@endif
                                    {{ $task->due_date->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-text-muted dark:text-text-darkMuted text-sm">—</span>
                            @endif
                        </td>
                        <td class="text-xs text-text-muted dark:text-text-darkMuted">{{ $task->created_at->format('d M') }}</td>
                        <td>
                            <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('tasks.show', $task) }}" class="btn-planova btn-ghost-p p-1.5" title="Lihat detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('tasks.edit', $task) }}" class="btn-planova btn-ghost-p p-1.5" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('tasks.destroy', $task) }}" data-ajax="true" data-confirm-message="Hapus task ini?" data-remove-target="tr">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-planova btn-ghost-p text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 p-1.5" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection
