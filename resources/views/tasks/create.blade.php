@extends('layouts.app')

@section('title', 'Task Baru')
@section('page_title', 'Task Baru')

@php
    $breadcrumbs = [
        ['label' => 'Tasks', 'url' => route('tasks.index')],
        ['label' => 'Buat Task Baru'],
    ];
@endphp

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-text-main dark:text-text-darkMain">Buat Task Baru</h1>
</div>

<div class="max-w-2xl">
    <div class="pcard animate-fade-in-up">
        <form method="POST" action="{{ route('tasks.store') }}" id="create-task-form" class="space-y-6">
            @csrf

            <div>
                <label for="title" class="form-label-p">Judul Task <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" class="form-control-p" value="{{ old('title') }}" placeholder="Apa yang perlu dikerjakan?" required autofocus>
                @error('title')<div class="text-sm text-red-500 mt-1">{{ $message }}</div>@enderror
            </div>

            <div>
                <label for="description" class="form-label-p">Deskripsi Singkat</label>
                <textarea id="description" name="description" class="form-control-p" rows="3" placeholder="Tambahkan deskripsi singkat (opsional)…">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="status" class="form-label-p">Status</label>
                    <select id="status" name="status" class="form-control-p form-select-p">
                        <option value="todo"        {{ old('status', 'todo') === 'todo'        ? 'selected' : '' }}>Todo</option>
                        <option value="in_progress" {{ old('status') === 'in_progress'         ? 'selected' : '' }}>In Progress</option>
                        <option value="done"        {{ old('status') === 'done'                ? 'selected' : '' }}>Done</option>
                    </select>
                </div>

                <div>
                    <label for="due_date" class="form-label-p">Due Date</label>
                    <input type="date" id="due_date" name="due_date" class="form-control-p" value="{{ old('due_date') }}">
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-planova btn-primary-p">
                    <i class="bi bi-check-lg"></i> Buat Task
                </button>
                <a href="{{ route('tasks.index') }}" class="btn-planova btn-secondary-p">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
