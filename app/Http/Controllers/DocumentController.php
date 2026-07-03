<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Daftar dokumen
     */
    public function index()
    {
        $documents = auth()->user()
            ->documents()
            ->latest()
            ->get();

        return view('documents.index', compact('documents'));
    }

    /**
     * Form create (tidak dipakai)
     */
    public function create()
    {
        return redirect()->route('documents.index');
    }

    /**
     * Upload dokumen
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'max:51200',
            ],
        ]);

        $file = $request->file('file');

        $path = $file->store('documents', 'public');

        Document::create([
            'user_id'   => auth()->id(),
            'title'     => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $file->getMimeType(),
            'extension' => strtolower($file->getClientOriginalExtension()),
            'file_size' => $file->getSize(),
        ]);

        return redirect()
            ->route('documents.index')
            ->with('success', 'Dokumen berhasil diupload.');
    }

    /**
     * Preview dokumen
     */
    public function show(Document $document)
    {
        abort_if($document->user_id != auth()->id(), 403);

        return view('documents.show', compact('document'));
    }

    /**
     * Form edit (tidak dipakai)
     */
    public function edit(Document $document)
    {
        return redirect()->route('documents.show', $document);
    }

    /**
     * Rename dokumen
     */
    public function update(Request $request, Document $document)
    {
        abort_if($document->user_id != auth()->id(), 403);

        $request->validate([
            'title' => 'required|max:255',
        ]);

        $document->update([
            'title' => $request->title,
        ]);

        return redirect()
            ->route('documents.show', $document)
            ->with('success', 'Nama dokumen berhasil diubah.');
    }

    /**
     * Download dokumen
     */
    public function download(Document $document)
    {
        abort_if($document->user_id != auth()->id(), 403);

        if (!Storage::disk('public')->exists($document->file_path)) {
            return redirect()
                ->route('documents.index')
                ->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download(
            $document->file_path,
            $document->file_name
        );
    }

    /**
     * Hapus dokumen
     */
    public function destroy(Document $document)
    {
        abort_if($document->user_id != auth()->id(), 403);

        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()
            ->route('documents.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }
}