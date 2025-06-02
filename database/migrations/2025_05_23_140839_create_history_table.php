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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->string('disease_name');
            $table->string('disease_class')->nullable(); // Original class name from model
            $table->decimal('accuracy', 5, 2);
            $table->boolean('is_healthy')->default(false);
            $table->text('symptoms')->nullable();
            $table->text('causes')->nullable();
            $table->text('prevention')->nullable();
            $table->text('treatment')->nullable();
            $table->enum('severity', ['none', 'low', 'medium', 'high', 'unknown'])->default('unknown');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};