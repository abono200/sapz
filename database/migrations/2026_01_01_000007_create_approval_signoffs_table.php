<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approval_signoffs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('approval_request_id');
            $table->foreign('approval_request_id')->references('id')->on('approval_requests')->onDelete('cascade');
            $table->uuid('step_id')->nullable();
            $table->foreign('step_id')->references('id')->on('workflow_steps')->onDelete('set null');
            $table->uuid('signoff_by');
            $table->foreign('signoff_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('signature_hash');
            $table->boolean('security_pin_verified')->default(true);
            $table->text('comments')->nullable();
            $table->timestamps();
        });

        Schema::create('approval_delegations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->uuid('delegated_to_user_id');
            $table->foreign('delegated_to_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approval_delegations');
        Schema::dropIfExists('approval_signoffs');
    }
};
