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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id(); // Kolom 'id'
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Kolom 'user_id' dengan foreign key
            $table->string('action'); // Kolom 'action'
            $table->text('description')->nullable(); // Kolom 'description'
            $table->string('model_type')->nullable(); // Kolom 'model_type'
            $table->unsignedBigInteger('model_id')->nullable(); // Kolom 'model_id'
            $table->json('old_data')->nullable(); // Kolom 'old_data' (untuk menyimpan JSON)
            $table->json('new_data')->nullable(); // Kolom 'new_data' (untuk menyimpan JSON)
            $table->ipAddress('ip_address')->nullable(); // Kolom 'ip_address'
            $table->text('user_agent')->nullable(); // Kolom 'user_agent'
            $table->timestamps(); // Kolom 'created_at' dan 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};