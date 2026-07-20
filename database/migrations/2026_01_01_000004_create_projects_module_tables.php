<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_zones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('state');
            $table->string('commodity_focus'); // RICE, CASSAVA, LIVESTOCK, COCOA, MAIZE, POULTRY
            $table->string('coordinates')->nullable();
            $table->timestamps();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->uuid('zone_id')->nullable()->after('created_by');
            $table->foreign('zone_id')->references('id')->on('project_zones')->onDelete('set null');
            $table->decimal('executed_budget', 15, 2)->default(0.00)->after('budget');
            $table->string('contractor_name')->nullable()->after('status');
        });

        Schema::create('project_milestones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->string('title');
            $table->integer('percentage_weight')->default(10);
            $table->string('status')->default('PENDING'); // PENDING, IN_PROGRESS, COMPLETED, DELAYED
            $table->date('due_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_milestones');
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['zone_id']);
            $table->dropColumn(['zone_id', 'executed_budget', 'contractor_name']);
        });
        Schema::dropIfExists('project_zones');
    }
};
