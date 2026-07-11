<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_property_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_id')
                  ->constrained('task_properties')
                  ->cascadeOnDelete();
            // Stores the value: for select = option id (string), for others = raw value
            $table->text('value')->nullable();
            $table->timestamps();

            // Each task can have one value per property
            $table->unique(['task_id', 'property_id']);
            $table->index(['task_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_property_values');
    }
};
