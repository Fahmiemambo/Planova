<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');

        $tasks = Task::forUser(Auth::id())
            ->byStatus($status)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tasks.index', compact('tasks', 'status'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'    => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status'   => ['required', 'in:todo,in_progress,done'],
            'due_date' => ['nullable', 'date'],
            'priority' => ['nullable', 'integer', 'min:0', 'max:2'],
        ]);

        $task = Task::create([
            ...$data,
            'user_id' => Auth::id(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Task berhasil dibuat!'
            ]);
        }

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Task berhasil dibuat!');
    }

    public function show(Task $task)
    {
        $this->authorizeTask($task);
        $task->load('blocks');
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->authorizeTask($task);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'in:todo,in_progress,done'],
            'due_date'    => ['nullable', 'date'],
            'priority'    => ['nullable', 'integer', 'min:0', 'max:2'],
        ]);

        $task->update($data);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Task berhasil diperbarui!'
            ]);
        }

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Task berhasil diperbarui!');
    }

    public function destroy(Task $task)
    {
        $this->authorizeTask($task);
        $task->blocks()->delete();
        $task->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Task berhasil dihapus.'
            ]);
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Task berhasil dihapus.');
    }

    private function authorizeTask(Task $task): void
    {
        abort_if($task->user_id !== Auth::id(), 403);
    }
}
