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
        Schema::create('services_types', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')->constrained('service_categories')->cascadeOnDelete();

            $table->string('slug')->unique();

            $table->string('name');
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            $table->string('thumbnail')->nullable();
            $table->string('icon')->nullable();

            $table->string('estimated_time')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('price_type')->nullable();

            $table->boolean('documented')->default(false);
            $table->boolean('visit_required')->default(false);

            $table->enum('status', ['active', 'inactive', 'draft'])->default('active');

            $table->integer('sort_order')->default(0);

            $table->json('advantages')->nullable();
            $table->json('requirements')->nullable();
            $table->json('steps')->nullable();
            $table->json('faqs')->nullable();
            $table->json('gallery')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->foreignId('created_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services_types');
    }
};
