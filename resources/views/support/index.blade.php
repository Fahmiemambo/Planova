@extends('layouts.app')

@section('title', 'Support')
@section('page_title', 'Support Developer')

@section('content')
<div class="max-w-3xl mx-auto py-12">
    <div class="pcard p-8 text-center">
        <h2 class="text-2xl font-bold mb-4">Dukungan / Support</h2>
        <p class="text-sm text-text-secondary mb-6">Scan QRIS di bawah untuk memberi donasi/support kepada pengembang.</p>

        <div class="mx-auto w-56 h-56 bg-white rounded-lg shadow-inner flex items-center justify-center overflow-hidden">
            <img src="{{ asset('images/qris-developer.png') }}" alt="QRIS Developer" class="max-w-full max-h-full" onerror="this.style.display='none'; document.getElementById('qris-fallback').style.display='block'">
            <div id="qris-fallback" style="display:none" class="p-4 text-sm text-text-muted">QRIS belum diunggah. Silakan letakkan file di <strong>public/images/qris-developer.png</strong></div>
        </div>

        <p class="text-xs text-text-muted mt-6">Terima kasih atas dukungan Anda.</p>
    </div>
</div>
@endsection
