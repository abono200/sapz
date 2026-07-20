<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('task_number')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default('TODO'); // TODO, IN_PROGRESS, IN_REVIEW, COMPLETED, BLOCKED
            $table->string('priority')->default('MEDIUM'); // LOW, MEDIUM, HIGH, CRITICAL
            $table->uuid('project_id')->nullable();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('set null');
            $table->uuid('assignee_id')->nullable();
            $table->foreign('assignee_id')->references('id')->on('users')->onDelete('set null');
            $table->uuid('reporter_id')->nullable();
            $table->foreign('reporter_id')->references('id')->on('users')->onDelete('set null');
            $table->date('due_date')->nullable();
            $table->decimal('estimated_hours', 8, 2)->default(0.00);
            $table->decimal('logged_hours', 8, 2)->default(0.00);
            $table->uuid('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('task_comments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('task_id');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('comment');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_comments');
        Schema::dropIfExists('tasks');
    }
};
