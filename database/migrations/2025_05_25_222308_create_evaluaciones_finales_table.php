<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('evaluaciones_finales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ova_id')->constrained('ovas')->onDelete('cascade');
            $table->string('titulo');
            $table->text('instrucciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluaciones_finales');
    }
};