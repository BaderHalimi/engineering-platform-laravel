<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('external_websites', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255);
            $table->string('url')->unique();
            $table->string('remixicon')->nullable();

            $table->text('description')->nullable();
            $table->json('meta')->nullable();

            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('is_active');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('external_websites');
    }
};
