<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            // Polymorphic relation: works with Task, Note, or any future model
            $table->morphs('blockable'); // blockable_id + blockable_type
            $table->enum('type', ['text', 'heading', 'todo', 'bullet_list', 'table', 'divider'])
                  ->default('text');
            $table->json('content')->nullable()->comment('Block payload: text, level, checked, rows, etc.');
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();

            $table->index(['blockable_type', 'blockable_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
};
