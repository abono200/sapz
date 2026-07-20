<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_versions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('document_id');
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->string('version_number')->default('1.0');
            $table->string('file_path');
            $table->bigInteger('file_size')->default(0);
            $table->string('mime_type')->default('application/pdf');
            $table->string('sha256_hash');
            $table->uuid('uploaded_by')->nullable();
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('document_downloads', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('document_id');
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->uuid('version_id')->nullable();
            $table->foreign('version_id')->references('id')->on('document_versions')->onDelete('set null');
            $table->uuid('downloaded_by')->nullable();
            $table->foreign('downloaded_by')->references('id')->on('users')->onDelete('set null');
            $table->string('ip_address')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_downloads');
        Schema::dropIfExists('document_versions');
    }
};
