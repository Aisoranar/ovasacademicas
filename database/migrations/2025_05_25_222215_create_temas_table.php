<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('temas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->comment('Nombre del tema');
            $table->text('descripcion')->nullable()->comment('Descripción del tema');
            $table->foreignId('programa_academico_id')
                  ->constrained('programas_academicos')
                  ->onDelete('cascade')
                  ->comment('Programa académico al que pertenece el tema');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temas');
    }
};