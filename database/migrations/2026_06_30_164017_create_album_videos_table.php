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
            Schema::create('album_videos', function (Blueprint $table) {
                $table->id();

                $table->foreignId('user_id')->constrained()->cascadeOnDelete();

                $table->string('title');
                $table->string('slug')->unique();

                $table->longText('description')->nullable();


                $table->string('video_path')->nullable();
                $table->longText('embed')->nullable();
                //$table->string('provider')->nullable();

                $table->unsignedInteger('duration')->nullable();

                $table->string('thumbnail');

                $table->unsignedBigInteger('views')->default(0);
                $table->unsignedBigInteger('likes')->default(0);
                $table->unsignedBigInteger('dislikes')->default(0);
                $table->unsignedBigInteger('shares')->default(0);
                $table->unsignedBigInteger('comments_count')->default(0);

                $table->boolean('is_published')->default(false);
                $table->boolean('is_featured')->default(false);
                $table->boolean('allow_comments')->default(true);

                $table->timestamp('published_at')->nullable();

                $table->string('canonical_url')->nullable();

                $table->string('seo_title')->nullable();
                $table->text('seo_description')->nullable();
                $table->string('seo_keywords')->nullable();

                $table->string('og_title')->nullable();
                $table->text('og_description')->nullable();
                $table->string('og_image')->nullable();

                $table->json('seo_json')->nullable();

                $table->string('language', 10)->default('en');
                $table->string('visibility')->default('public');

                $table->json('meta')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->index('user_id');
                $table->index('slug');
                //$table->index('provider');
                $table->index('published_at');
                $table->index('is_published');
                $table->index('is_featured');
                $table->index('views');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('album_videos');
    }
};
