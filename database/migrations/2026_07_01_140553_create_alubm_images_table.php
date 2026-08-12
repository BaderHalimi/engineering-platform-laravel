<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('album_images', function (Blueprint $table) {
            $table->id();

            // Basic
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Image
            $table->string('image_path');
            $table->string('thumbnail_path')->nullable();
            $table->string('alt_text')->nullable();

            // Commercial
            $table->enum('visibility', ['public', 'private', 'draft'])->default('public');
            $table->boolean('featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);

            // Statistics
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('likes')->default(0);
            $table->unsignedBigInteger('downloads')->default(0);
            $table->unsignedBigInteger('shares')->default(0);

            // SEO
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->boolean('indexable')->default(true);

            // Open Graph
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();

            // Flexible data
            $table->json('meta')->nullable();

            // Relations
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();

            // Indexes
            $table->index('visibility');
            $table->index('featured');
            $table->index('sort_order');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('album_images');
    }
};
