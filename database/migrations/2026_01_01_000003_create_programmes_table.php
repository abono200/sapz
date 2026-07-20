<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programmes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('funder')->default('IFAD / AfDB / IsDB');
            $table->decimal('total_allocation', 15, 2)->default(0.00);
            $table->string('status')->default('PLANNING'); // PLANNING, ACTIVE, COMPLETED, ON_HOLD
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->uuid('coordinator_id')->nullable();
            $table->foreign('coordinator_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('programme_milestones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('programme_id');
            $table->foreign('programme_id')->references('id')->on('programmes')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('target_date');
            $table->string('status')->default('PENDING'); // PENDING, IN_PROGRESS, ACHIEVED, DELAYED
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programme_milestones');
        Schema::dropIfExists('programmes');
    }
};
