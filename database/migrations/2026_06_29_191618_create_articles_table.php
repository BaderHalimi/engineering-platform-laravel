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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            $table->string('title', 255);
            $table->string('slug')->unique();
            $table->longText('content');
            $table->string('thumbnail')->nullable();
            $table->json('attachments')->nullable();

            // SEO & Meta
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();
            $table->string('og_image')->nullable();
            $table->string('canonical_url')->nullable();

            // حالة النشر
            $table->enum('status', ['draft', 'published', 'archived', 'pending'])->default('draft');
            $table->timestamp('published_at')->nullable();

            // علاقات
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()
                    ->constrained('article_categories')
                    ->onDelete('set null');
            // إحصائيات
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('reading_time')->default(0);

            // ميزات إضافية
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_trending')->default(false);
            $table->json('tags')->nullable();



            $table->timestamps();
            $table->softDeletes();

            // Indexes للأداء
            $table->index(['status', 'published_at']);
            $table->index('views');
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
