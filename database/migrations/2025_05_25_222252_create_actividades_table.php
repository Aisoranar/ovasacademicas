<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ova_id')->constrained('ovas')->onDelete('cascade');
            $table->string('nombre')->comment('Título de la actividad');
            $table->enum('tipo', ['video','lectura','ejercicio','otro'])->default('otro');
            $table->text('descripcion')->nullable();
            $table->integer('orden')->default(1);
            $table->integer('duracion')->comment('Duración en minutos');
            $table->text('instrucciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};