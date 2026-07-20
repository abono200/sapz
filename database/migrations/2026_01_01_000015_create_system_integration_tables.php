<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_clients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('client_name');
            $table->string('api_key')->unique();
            $table->string('secret_hash');
            $table->string('allowed_ip_range')->nullable();
            $table->integer('rate_limit')->default(1000); // Requests per hour
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('webhook_endpoints', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('api_clients')->onDelete('cascade');
            $table->string('target_url');
            $table->string('event_type'); // PROJECT_UPDATED, DOCUMENT_APPROVED, TASK_COMPLETED
            $table->string('secret_token');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('webhook_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('webhook_id');
            $table->foreign('webhook_id')->references('id')->on('webhook_endpoints')->onDelete('cascade');
            $table->string('event_type');
            $table->json('payload_json');
            $table->integer('response_status')->nullable();
            $table->integer('attempts')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webhook_logs');
        Schema::dropIfExists('webhook_endpoints');
        Schema::dropIfExists('api_clients');
    }
};
