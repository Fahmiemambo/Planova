<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('assignee_id')->nullable()->after('user_id')->constrained('users')->nullOnDelete();
            $table->string('cover')->nullable()->after('description');
            $table->string('icon')->nullable()->after('cover');
            // Since modifying enum is problematic without dbal, we add a new column for custom status and priority if needed
            // But since this is a new feature, let's just add a string column 'custom_status' and 'custom_priority'
            $table->string('custom_status')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['assignee_id']);
            $table->dropColumn(['assignee_id', 'cover', 'icon', 'custom_status']);
        });
    }
};
