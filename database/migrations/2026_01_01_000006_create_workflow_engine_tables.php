<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workflow_steps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('workflow_id');
            $table->foreign('workflow_id')->references('id')->on('workflows')->onDelete('cascade');
            $table->integer('step_order');
            $table->string('name');
            $table->uuid('approver_role_id')->nullable();
            $table->foreign('approver_role_id')->references('id')->on('roles')->onDelete('set null');
            $table->uuid('approver_user_id')->nullable();
            $table->foreign('approver_user_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('approval_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('workflow_id');
            $table->foreign('workflow_id')->references('id')->on('workflows')->onDelete('cascade');
            $table->string('approvable_type');
            $table->uuid('approvable_id');
            $table->uuid('requester_id');
            $table->foreign('requester_id')->references('id')->on('users')->onDelete('cascade');
            $table->uuid('current_step_id')->nullable();
            $table->foreign('current_step_id')->references('id')->on('workflow_steps')->onDelete('set null');
            $table->string('status')->default('SUBMITTED'); // SUBMITTED, PENDING_APPROVAL, APPROVED, REJECTED, REVISION_REQUESTED
            $table->timestamps();
        });

        Schema::create('approval_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('approval_request_id');
            $table->foreign('approval_request_id')->references('id')->on('approval_requests')->onDelete('cascade');
            $table->uuid('step_id')->nullable();
            $table->foreign('step_id')->references('id')->on('workflow_steps')->onDelete('set null');
            $table->uuid('approver_id');
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('action'); // APPROVED, REJECTED, REVISED
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approval_histories');
        Schema::dropIfExists('approval_requests');
        Schema::dropIfExists('workflow_steps');
    }
};
