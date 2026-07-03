<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskApiController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::with(['tags', 'attachments', 'assignee'])->forUser(Auth::id())->get();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'nullable|string',
            'custom_status' => 'nullable|string',
            'priority' => 'nullable|integer',
        ]);

        $validated['user_id'] = Auth::id();
        $task = Task::create($validated);
        
        return response()->json($task->load(['tags', 'attachments', 'assignee']));
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) abort(403);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'status' => 'nullable|string',
            'custom_status' => 'nullable|string',
            'description' => 'nullable|string',
            'priority' => 'nullable|integer',
            'due_date' => 'nullable|date',
            'assignee_id' => 'nullable|exists:users,id',
            'cover' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);

        $task->update($validated);
        
        // Handle tags later
        
        return response()->json($task->load(['tags', 'attachments', 'assignee']));
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) abort(403);
        $task->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
