<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $notes = auth()->user()->notes()->latest()->get();
        return view('notes.index', compact('notes'));
    }

    public function store(Request $request)
    {
        $note = auth()->user()->notes()->create([
            'title' => 'Untitled Note',
            'icon' => 'bi-file-earmark-text',
        ]);

        return redirect()->route('notes.show', $note);
    }

    public function show(Note $note)
    {
        if ($note->user_id !== auth()->id()) abort(403);
        
        $note->load('blocks');
        return view('notes.show', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        if ($note->user_id !== auth()->id()) abort(403);
        
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
        ]);

        $note->update($data);

        return response()->json(['success' => true]);
    }

    public function destroy(Note $note)
    {
        if ($note->user_id !== auth()->id()) abort(403);
        
        $note->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Catatan berhasil dihapus.'
            ]);
        }
        
        return redirect()->route('notes.index')->with('success', 'Catatan berhasil dihapus.');
    }
}
