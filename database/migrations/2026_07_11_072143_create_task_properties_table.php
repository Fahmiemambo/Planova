<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_properties', function (Blueprint $table) {
            $table->id();
            // Owner of the property definition (per-user)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Human-readable name shown in the UI (e.g. "Status", "Priority")
            $table->string('name');
            // Type: select | text | date | checkbox | number | url
            $table->string('type')->default('select');
            // JSON config — for 'select': {"options":[{"id":"uuid","label":"Belum Dimulai","color":"#ef4444","group":"To-do"},...]}
            $table->json('config')->nullable();
            // Display order among all properties of this user
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();

            $table->index(['user_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_properties');
    }
};
