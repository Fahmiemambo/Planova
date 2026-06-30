@extends('layouts.app')

@section('title', 'Edit: ' . $task->title)
@section('page_title', 'Edit Task')

@php
    $breadcrumbs = [
        ['label' => 'Tasks', 'url' => route('tasks.index')],
        ['label' => $task->title, 'url' => route('tasks.show', $task)],
        ['label' => 'Edit'],
    ];
@endphp

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-text-main dark:text-text-darkMain">Edit Task</h1>
</div>

<div class="max-w-2xl">
    <div class="pcard animate-fade-in-up">
        <form method="POST" action="{{ route('tasks.update', $task) }}" id="edit-task-form" class="space-y-6">
            @csrf @method('PUT')

            <div>
                <label for="title" class="form-label-p">Judul Task <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" class="form-control-p" value="{{ old('title', $task->title) }}" required autofocus>
                @error('title')<div class="text-sm text-red-500 mt-1">{{ $message }}</div>@enderror
            </div>

            <div>
                <label for="description" class="form-label-p">Deskripsi Singkat</label>
                <textarea id="description" name="description" class="form-control-p" rows="3">{{ old('description', $task->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="status" class="form-label-p">Status</label>
                    <select id="status" name="status" class="form-control-p form-select-p">
                        <option value="todo"        {{ old('status', $task->status) === 'todo'        ? 'selected' : '' }}>Todo</option>
                        <option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="done"        {{ old('status', $task->status) === 'done'        ? 'selected' : '' }}>Done</option>
                    </select>
                </div>

                <div>
                    <label for="due_date" class="form-label-p">Due Date</label>
                    <input type="date" id="due_date" name="due_date" class="form-control-p" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-planova btn-primary-p">
                    <i class="bi bi-check-lg"></i> Simpan Perubahan
                </button>
                <a href="{{ route('tasks.show', $task) }}" class="btn-planova btn-secondary-p">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
