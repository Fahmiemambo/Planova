<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlockController extends Controller
{
    /**
     * Create a new block for a blockable entity.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'blockable_type' => ['required', 'string'],
            'blockable_id'   => ['required', 'integer'],
            'type'           => ['required', 'in:text,heading,todo,bullet_list,table,divider'],
            'content'        => ['nullable', 'array'],
            'order'          => ['nullable', 'integer'],
        ]);

        // Authorize ownership
        $this->authorizeBlockable($data['blockable_type'], $data['blockable_id']);

        // Determine next order
        if (!isset($data['order'])) {
            $maxOrder = Block::where('blockable_type', $data['blockable_type'])
                ->where('blockable_id', $data['blockable_id'])
                ->max('order');
            $data['order'] = ($maxOrder ?? -1) + 1;
        }

        $data['content'] = $data['content'] ?? $this->defaultContent($data['type']);

        $block = Block::create($data);

        $html = view('components.block.item', compact('block'))->render();

        return response()->json([
            'success' => true,
            'block'   => $block,
            'html'    => $html,
        ]);
    }

    /**
     * Update a block's content.
     */
    public function update(Request $request, Block $block)
    {
        $this->authorizeBlockable($block->blockable_type, $block->blockable_id);

        $data = $request->validate([
            'content' => ['nullable', 'array'],
            'type'    => ['nullable', 'in:text,heading,todo,bullet_list,table,divider'],
        ]);

        $block->update(array_filter($data, fn($v) => $v !== null));

        return response()->json(['success' => true, 'block' => $block->fresh()]);
    }

    /**
     * Delete a block.
     */
    public function destroy(Block $block)
    {
        $this->authorizeBlockable($block->blockable_type, $block->blockable_id);
        $block->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Reorder blocks via drag & drop.
     * Expects: { blockable_type, blockable_id, order: [id1, id2, ...] }
     */
    public function reorder(Request $request)
    {
        $data = $request->validate([
            'blockable_type' => ['required', 'string'],
            'blockable_id'   => ['required', 'integer'],
            'order'          => ['required', 'array'],
            'order.*'        => ['integer'],
        ]);

        $this->authorizeBlockable($data['blockable_type'], $data['blockable_id']);

        foreach ($data['order'] as $index => $blockId) {
            Block::where('id', $blockId)
                ->where('blockable_type', $data['blockable_type'])
                ->where('blockable_id', $data['blockable_id'])
                ->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Ensure the current user owns the blockable parent.
     */
    private function authorizeBlockable(string $type, int $id): void
    {
        if ($type === 'App\\Models\\Task') {
            $model = Task::findOrFail($id);
            abort_if($model->user_id !== Auth::id(), 403);
        } elseif ($type === 'App\\Models\\Note') {
            $model = \App\Models\Note::findOrFail($id);
            abort_if($model->user_id !== Auth::id(), 403);
        } else {
            abort(403, 'Unsupported blockable type.');
        }
    }

    private function defaultContent(string $type): array
    {
        return match($type) {
            'text'        => ['text' => ''],
            'heading'     => ['text' => '', 'level' => 2],
            'todo'        => ['text' => '', 'checked' => false],
            'bullet_list' => ['text' => ''],
            'table'       => ['headers' => ['Kolom 1', 'Kolom 2'], 'rows' => [['', '']]],
            'divider'     => [],
            default       => [],
        };
    }
}
