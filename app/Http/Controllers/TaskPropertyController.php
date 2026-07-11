<?php

namespace App\Http\Controllers;

use App\Models\TaskProperty;
use App\Models\TaskPropertyValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TaskPropertyController extends Controller
{
    // ── Property Definitions ───────────────────────────────

    /**
     * GET /task-properties
     * Return all properties for the authenticated user (used to populate sidebar on page load).
     */
    public function index()
    {
        $properties = TaskProperty::where('user_id', Auth::id())
            ->orderBy('position')
            ->get();

        return response()->json($properties);
    }

    /**
     * POST /task-properties
     * Create a new property definition.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', 'in:select,status,text,date,checkbox,number,url,email,phone,person,multi_select,formula'],
        ]);

        // Place it after all existing properties
        $maxPosition = TaskProperty::where('user_id', Auth::id())->max('position') ?? -1;

        // Seed with a default option for 'select' and 'status' types
        $config = null;
        if (in_array($data['type'], ['select', 'status'])) {
            $config = $data['type'] === 'status'
                ? ['options' => [
                    ['id' => (string) Str::uuid(), 'label' => 'Belum Dimulai', 'color' => '#ef4444', 'group' => 'To-do'],
                    ['id' => (string) Str::uuid(), 'label' => 'Dalam Proses',  'color' => '#eab308', 'group' => 'In progress'],
                    ['id' => (string) Str::uuid(), 'label' => 'Selesai',        'color' => '#22c55e', 'group' => 'Complete'],
                ]]
                : ['options' => [
                    ['id' => (string) Str::uuid(), 'label' => 'Option 1', 'color' => '#6b7280', 'group' => ''],
                ]];
        }

        $property = TaskProperty::create([
            'user_id'  => Auth::id(),
            'name'     => $data['name'],
            'type'     => $data['type'],
            'config'   => $config,
            'position' => $maxPosition + 1,
        ]);

        return response()->json($property, 201);
    }

    /**
     * PUT /task-properties/{property}
     * Update a property definition (name, config/options).
     */
    public function update(Request $request, TaskProperty $property)
    {
        $this->authorizeProperty($property);

        $data = $request->validate([
            'name'   => ['sometimes', 'string', 'max:100'],
            'config' => ['sometimes', 'nullable', 'array'],
        ]);

        // Ensure every option in config has a valid uuid id
        if (isset($data['config']['options'])) {
            $data['config']['options'] = array_map(function (array $opt) {
                if (empty($opt['id'])) {
                    $opt['id'] = (string) Str::uuid();
                }
                return $opt;
            }, $data['config']['options']);
        }

        $property->update($data);

        return response()->json($property->fresh());
    }

    /**
     * DELETE /task-properties/{property}
     * Delete a property definition and all its values.
     */
    public function destroy(TaskProperty $property)
    {
        $this->authorizeProperty($property);
        $property->values()->delete();
        $property->delete();

        return response()->json(['success' => true]);
    }

    /**
     * POST /task-properties/reorder
     * Persist drag-and-drop order of property definitions.
     */
    public function reorder(Request $request)
    {
        $data = $request->validate([
            'property_ids'   => ['required', 'array'],
            'property_ids.*' => ['integer'],
        ]);

        foreach ($data['property_ids'] as $pos => $id) {
            TaskProperty::where('id', $id)
                ->where('user_id', Auth::id())
                ->update(['position' => $pos]);
        }

        return response()->json(['success' => true]);
    }

    // ── Property Values (per task) ─────────────────────────

    /**
     * POST /task-properties/{property}/values
     * Set (upsert) the value of a property for a specific task.
     */
    public function setValue(Request $request, TaskProperty $property)
    {
        $this->authorizeProperty($property);

        $data = $request->validate([
            'task_id' => ['required', 'integer', 'exists:tasks,id'],
            'value'   => ['nullable', 'string', 'max:2000'],
        ]);

        // Make sure the task belongs to this user
        $task = \App\Models\Task::where('id', $data['task_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $value = TaskPropertyValue::updateOrCreate(
            ['task_id' => $task->id, 'property_id' => $property->id],
            ['value' => $data['value']]
        );

        // Resolve the option for select types so the frontend can update the badge immediately
        $resolved = null;
        if ($property->type === 'select' && $data['value']) {
            $resolved = $property->findOption($data['value']);
        }

        return response()->json([
            'value'    => $value,
            'resolved' => $resolved,
        ]);
    }

    /**
     * DELETE /task-properties/{property}/values/{task}
     * Clear the value of a property for a specific task.
     */
    public function clearValue(TaskProperty $property, int $taskId)
    {
        $this->authorizeProperty($property);

        TaskPropertyValue::where('task_id', $taskId)
            ->where('property_id', $property->id)
            ->delete();

        return response()->json(['success' => true]);
    }

    // ── Private ────────────────────────────────────────────

    private function authorizeProperty(TaskProperty $property): void
    {
        abort_if($property->user_id !== Auth::id(), 403);
    }
}
