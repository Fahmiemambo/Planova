@extends('layouts.app')

@section('title','Document')

@section('content')

<div class="max-w-5xl mx-auto">

<h1 class="text-3xl font-bold">

{{ $document->file_name }}

</h1>

<div class="mt-3 flex gap-3">

<a
href="{{ route('documents.download',$document) }}"
class="btn-planova btn-primary-p">

Download

</a>

<a
href="{{ route('documents.index') }}"
class="btn-planova">

Kembali

</a>

<form
action="{{ route('documents.destroy',$document) }}"
method="POST">

@csrf
@method('DELETE')

<button
type="submit"
onclick="return confirm('Hapus dokumen ini?')"
class="btn-planova bg-red-600 text-white">

Hapus

</button>

</form>

</div>

@if(Str::startsWith($document->mime_type,'image/'))

<img
src="{{ asset('storage/'.$document->file_path) }}"
class="mt-6 rounded-xl shadow">

@elseif($document->mime_type=='application/pdf')

<iframe
src="{{ asset('storage/'.$document->file_path) }}"
class="w-full h-[700px] mt-6 rounded-xl">

</iframe>

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