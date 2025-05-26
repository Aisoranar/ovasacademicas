<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ovas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->comment('Título del OVA');
            $table->string('slug')->unique()->comment('URL amigable');
            $table->text('descripcion')->comment('Descripción detallada');
            $table->text('objetivos_aprendizaje')->nullable()->comment('Objetivos de aprendizaje');
            $table->integer('duracion_total')->comment('Duración en minutos');
            $table->enum('nivel_dificultad', ['básico','intermedio','avanzado'])->default('básico');
            $table->string('version', 10)->default('1.0.0');
            $table->dateTime('fecha_publicacion')->nullable();
            $table->enum('estado', ['borrador', 'revision', 'publicado', 'archivado'])->default('borrador');
            $table->string('imagen_portada')->nullable();
            $table->unsignedBigInteger('numero_visualizaciones')->default(0);
            $table->unsignedTinyInteger('nivel_interactividad')->default(1)->comment('Nivel de interactividad (1-5)');
            $table->foreignId('docente_id')->constrained('users')->comment('Autor docente');
            $table->string('programa_academico')->comment('Programa académico al que pertenece el OVA');
            $table->foreignId('tema_id')->constrained('temas')->comment('Tema asociado');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ovas');
    }
};