<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('report_type'); // EXECUTIVE_SUMMARY, BUDGET_EXECUTION, AGRO_ZONE_METRICS, AUDIT_TRAIL
            $table->string('title');
            $table->json('parameters_json')->nullable();
            $table->string('output_path')->nullable();
            $table->string('export_format')->default('PDF'); // PDF, CSV, XLSX
            $table->uuid('generated_by')->nullable();
            $table->foreign('generated_by')->references('id')->on('users')->onDelete('set null');
            $table->string('status')->default('PENDING'); // PENDING, PROCESSING, COMPLETED, FAILED
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_reports');
    }
};
