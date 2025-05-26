<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etiquetas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->comment('Nombre de la etiqueta');
            $table->string('slug')->unique()->comment('Identificador único');
            $table->foreignId('programa_academico_id')
                  ->constrained('programas_academicos')
                  ->onDelete('cascade')
                  ->comment('Programa académico al que pertenece la etiqueta');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etiquetas');
    }
};