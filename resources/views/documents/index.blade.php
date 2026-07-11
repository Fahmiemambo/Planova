@extends('layouts.app')

@section('title', 'Documents')
@section('page_title', 'Documents')

@section('content')

<div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">

    <div>
        <h1 class="text-3xl font-bold text-text-main dark:text-text-darkMain">
            📁 Documents
        </h1>

        <p class="text-sm text-text-muted dark:text-text-darkMuted mt-2">
            Simpan Word, Excel, PDF, PowerPoint, gambar, ZIP dan file lainnya.
        </p>
    </div>

    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input
            id="uploadDocument"
            type="file"
            name="file"
            class="hidden"
            onchange="this.form.submit()">

        <button
            type="button"
            onclick="document.getElementById('uploadDocument').click()"
            class="btn-planova btn-primary-p">

            <i class="bi bi-upload"></i>
            Upload Dokumen

        </button>

    </form>

</div>

@if(session('success'))
<div class="mb-6 rounded-xl bg-green-100 text-green-700 px-5 py-3">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-6 rounded-xl bg-red-100 text-red-700 px-5 py-3">
    {{ session('error') }}
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <div class="pcard">
        <div class="text-sm text-text-muted">
            Total File
        </div>

        <div class="text-3xl font-bold mt-2">
            {{ $documents->count() }}
        </div>
    </div>

    <div class="pcard">
        <div class="text-sm text-text-muted">
            Storage
        </div>

        <div class="text-3xl font-bold mt-2">
            {{ number_format($documents->sum('file_size') / 1024 / 1024, 2) }} MB
        </div>
    </div>

    <div class="pcard">
        <input
            id="search"
            type="text"
            placeholder="Cari dokumen..."
            class="w-full rounded-lg border px-3 py-2">
    </div>

</div>

<div id="documentGrid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

@forelse($documents as $document)

@php

$icon = 'bi-file-earmark';

switch ($document->extension) {

    case 'pdf':
        $icon = 'bi-file-earmark-pdf text-red-500';
        break;

    case 'doc':
    case 'docx':
        $icon = 'bi-file-earmark-word text-blue-600';
        break;

    case 'xls':
    case 'xlsx':
        $icon = 'bi-file-earmark-excel text-green-600';
        break;

    case 'ppt':
    case 'pptx':
        $icon = 'bi-file-earmark-ppt text-orange-500';
        break;

    case 'jpg':
    case 'jpeg':
    case 'png':
    case 'gif':
    case 'webp':
        $icon = 'bi-file-image text-pink-500';
        break;

    case 'zip':
    case 'rar':
        $icon = 'bi-file-earmark-zip text-yellow-500';
        break;
}

@endphp

<div class="pcard workspace-item">

    <div class="flex justify-between">

        <div class="w-14 h-14 rounded-xl bg-surface-100 dark:bg-dark-surface2 flex items-center justify-center">
            <i class="bi {{ $icon }} text-3xl file-icon"></i>
        </div>

    </div>

    <a
        href="{{ route('documents.show', $document) }}"
        class="block mt-5 font-semibold text-lg break-all">

        {{ $document->file_name }}

    </a>

    <div class="text-sm mt-3 text-text-muted">
        {{ strtoupper($document->extension) }}
        •
        {{ number_format($document->file_size / 1024,2) }} KB
    </div>

    <div class="text-xs mt-2 text-text-muted">
        {{ $document->created_at->diffForHumans() }}
    </div>

    <div class="flex gap-3 mt-6">

        <a
            href="{{ route('documents.download', $document) }}"
            class="btn-planova btn-primary-p">

            <i class="bi bi-download"></i>

        </a>

        <form
            action="{{ route('documents.destroy', $document) }}"
            method="POST"
            data-ajax="true"
            data-confirm-message="Hapus dokumen ini?"
            data-remove-target=".workspace-item">

            @csrf
            @method('DELETE')

            <button
                type="submit"
                class="btn-delete">

                <i class="bi bi-trash-fill"></i>
                <span>Hapus</span>

            </button>

        </form>

    </div>

</div>
@empty

<div class="col-span-full">

    <div class="pcard text-center py-20">

        <div class="text-6xl mb-5">
            📁
        </div>

        <h2 class="text-2xl font-bold">
            Belum ada dokumen
        </h2>

        <p class="mt-3 text-text-muted">
            Upload Word, Excel, PDF, PowerPoint, gambar atau ZIP.
        </p>

    </div>

</div>

@endforelse

</div>

<script>

const search = document.getElementById('search');

if (search) {

    search.addEventListener('keyup', function () {

        let keyword = this.value.toLowerCase();

        document.querySelectorAll('.workspace-item').forEach(item => {

            item.style.display = item.innerText.toLowerCase().includes(keyword)
                ? 'block'
                : 'none';

        });

    });

}

</script>

@endsection