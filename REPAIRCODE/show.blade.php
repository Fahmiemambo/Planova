@extends('layouts.app')

@section('title','Document')
@section('page_title', 'Document Preview')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="pcard mb-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div class="min-w-0">
                <h1 class="text-2xl font-bold text-text-main dark:text-text-darkMain truncate">
                    {{ $document->file_name }}
                </h1>

                <div class="flex flex-wrap items-center gap-3 mt-2 text-sm text-text-muted">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-surface-100 font-semibold text-xs uppercase">
                        {{ $document->extension }}
                    </span>
                    <span>{{ number_format($document->file_size / 1024, 2) }} KB</span>
                    <span>{{ $document->created_at->diffForHumans() }}</span>
                </div>
            </div>

            <div class="flex items-center gap-3 flex-shrink-0">

                <a href="{{ route('documents.download', $document) }}"
                   class="btn-planova btn-primary-p">
                    <i class="bi bi-download"></i>
                    Download
                </a>

                <a href="{{ route('documents.index') }}"
                   class="btn-planova">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>

                <form action="{{ route('documents.destroy', $document) }}"
                      method="POST"
                      id="deleteFormShow">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            onclick="return confirm('Hapus dokumen ini?')"
                            class="btn-delete">
                        <i class="bi bi-trash-fill"></i>
                        <span>Hapus</span>
                    </button>
                </form>

            </div>

        </div>

    </div>

    {{-- Preview Area --}}
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
            <iframe src="{{ $previewUrl }}"
                    class="w-full rounded-xl border-0"
                    style="height: 80vh;"
                    title="PDF Preview: {{ $document->file_name }}">
            </iframe>
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

        <div class="pcard text-center py-16">
            <div class="w-20 h-20 rounded-2xl bg-surface-100 flex items-center justify-center mx-auto mb-5">
                <i class="bi bi-file-earmark text-4xl text-text-muted"></i>
            </div>

            <h3 class="text-xl font-bold text-text-main">
                Preview tidak tersedia
            </h3>

            <p class="mt-3 text-text-muted max-w-md mx-auto">
                File <strong>{{ strtoupper($document->extension) }}</strong> tidak bisa ditampilkan di browser.
                Silakan klik tombol <strong>Download</strong> untuk mengunduh file ini.
            </p>

            <a href="{{ route('documents.download', $document) }}"
               class="btn-planova btn-primary-p inline-flex items-center gap-2 mt-6">
                <i class="bi bi-download"></i>
                Download File
            </a>
        </div>

    @endif

</div>

@endsection