<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ckr_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('ckr_articles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('category_id');
            $table->foreign('category_id')->references('id')->on('ckr_categories')->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('summary')->nullable();
            $table->longText('content');
            $table->string('author_name')->default('SAPZ Research Team');
            $table->timestamp('published_at')->nullable();
            $table->bigInteger('view_count')->default(0);
            $table->bigInteger('download_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('ckr_tags', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('article_has_tags', function (Blueprint $table) {
            $table->uuid('article_id');
            $table->uuid('tag_id');
            $table->foreign('article_id')->references('id')->on('ckr_articles')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('ckr_tags')->onDelete('cascade');
            $table->primary(['article_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_has_tags');
        Schema::dropIfExists('ckr_tags');
        Schema::dropIfExists('ckr_articles');
        Schema::dropIfExists('ckr_categories');
    }
};
