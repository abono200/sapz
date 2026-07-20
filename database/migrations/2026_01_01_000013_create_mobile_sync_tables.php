<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('field_inspections', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->uuid('inspector_id');
            $table->foreign('inspector_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->date('inspection_date');
            $table->text('notes')->nullable();
            $table->string('status')->default('COMPLETED'); // COMPLETED, PENDING_REVIEW, FLAG_RAISED
            $table->timestamp('client_created_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('mobile_sync_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('device_id');
            $table->integer('items_synced')->default(0);
            $table->string('status')->default('SUCCESS'); // SUCCESS, CONFLICT_RESOLVED, FAILED
            $table->text('error_log')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobile_sync_sessions');
        Schema::dropIfExists('field_inspections');
    }
};
