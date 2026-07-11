@extends('layouts.app')

@section('title','Document')

@section('content')

<div class="max-w-5xl mx-auto">

<div class="pcard mb-6 p-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-text-main dark:text-text-darkMain truncate">
                {{ $document->file_name }}
            </h1>
            <div class="mt-2 text-sm text-text-muted dark:text-text-darkMuted">
                <span class="inline-flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-surface-200 text-xs font-semibold">{{ strtoupper($document->extension) }}</span>
                    {{ number_format($document->file_size / 1024, 2) }} KB • {{ $document->created_at->diffForHumans() }}
                </span>
            </div>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
            <a href="{{ route('documents.download',$document) }}" class="btn-planova btn-primary-p w-full sm:w-auto text-center">
                <i class="bi bi-download"></i>
                Download
            </a>
            <a href="{{ route('documents.index') }}" class="btn-planova w-full sm:w-auto text-center">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
            <form action="{{ route('documents.destroy', $document) }}" method="POST" data-ajax="true" data-confirm-message="Hapus dokumen ini?" data-redirect-url="{{ route('documents.index') }}" class="w-full sm:w-auto">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-planova bg-red-600 text-white w-full sm:w-auto">
                    <i class="bi bi-trash-fill"></i>
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@php
    $previewUrl = route('documents.preview', $document);
    $isImage    = Str::startsWith($document->mime_type, 'image/');
    $isPdf      = $document->mime_type === 'application/pdf';
    $isText     = in_array($document->extension, ['txt', 'csv', 'log', 'md', 'json', 'xml', 'html', 'css', 'js']);
    $isVideo    = Str::startsWith($document->mime_type, 'video/');
    $isAudio    = Str::startsWith($document->mime_type, 'audio/');
@endphp

@if($isImage)

    <div class="pcard p-4">
        <img src="{{ $previewUrl }}"
             alt="{{ $document->file_name }}"
             class="w-full rounded-xl shadow-sm"
             loading="lazy">
    </div>

@elseif($isPdf)

    <div class="pcard p-4">
        <object data="{{ $previewUrl }}"
                type="application/pdf"
                class="w-full rounded-xl border-0"
                style="height: 80vh;">
            <p class="text-sm text-text-muted">
                Tidak bisa menampilkan PDF secara langsung.
                <a href="{{ route('documents.download', $document) }}" class="text-primary underline">Klik di sini untuk download.</a>
            </p>
        </object>
    </div>

@elseif($isText)

    <div class="pcard p-4">
        <iframe src="{{ $previewUrl }}"
                class="w-full rounded-xl border border-surface-200 bg-white font-mono text-sm"
                style="height: 60vh;"
                title="Text Preview: {{ $document->file_name }}">
        </iframe>
    </div>

@elseif($isVideo)

    <div class="pcard p-4">
        <video controls class="w-full rounded-xl" preload="metadata">
            <source src="{{ $previewUrl }}" type="{{ $document->mime_type }}">
            Browser Anda tidak mendukung pemutar video.
        </video>
    </div>

@elseif($isAudio)

    <div class="pcard p-6 flex flex-col items-center gap-4">
        <div class="w-24 h-24 rounded-2xl bg-surface-100 flex items-center justify-center">
            <i class="bi bi-music-note-beamed text-4xl text-primary-p"></i>
        </div>
        <audio controls class="w-full max-w-lg" preload="metadata">
            <source src="{{ $previewUrl }}" type="{{ $document->mime_type }}">
            Browser Anda tidak mendukung pemutar audio.
        </audio>
    </div>

@else

    <div class="mt-10 p-8 rounded-xl bg-gray-100">

        <h3 class="font-bold text-xl">
            Preview tidak tersedia
        </h3>

        <p class="mt-3">
            File ini tidak bisa dipreview di browser.
            Silakan klik tombol Download.
        </p>

    </div>

@endif

</div>

@endsection