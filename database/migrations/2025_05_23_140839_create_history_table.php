<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
       Schema::create('histories', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('image_path');
        $table->string('disease_name');
        $table->decimal('accuracy', 5, 2);
        $table->boolean('is_healthy')->default(false);
        $table->text('solution')->nullable();
        $table->timestamps();
});
    }

    public function down()
    {
        Schema::dropIfExists('histories');
    }
};