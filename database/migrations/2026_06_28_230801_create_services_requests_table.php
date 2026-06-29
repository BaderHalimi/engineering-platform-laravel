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
        Schema::create('services_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services_types')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete(); //guest
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();

            $table->string('title');
            $table->string('reference')->unique();
            $table->text('reason')->nullable();
            $table->longText('details')->nullable();

            $table->text('admin_notes')->nullable();


            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled','rejected'])->default('pending');

            //customer info
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();

            $table->string('customer_address')->nullable();

            $table->json('documents')->nullable();
            $table->json("meta")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services_requests');
    }
};
