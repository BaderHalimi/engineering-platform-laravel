<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();

            $table->string('email')->index();
            $table->string('title', 255);
            $table->longText('content');

            $table->json('attachments')->nullable();
            $table->json('meta')->nullable();

            $table->timestamp('read_at')->nullable();
            $table->foreignId('read_by')
                                        ->nullable()
                                        ->constrained('users')
                                        ->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
