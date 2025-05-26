<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programas_academicos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->comment('Nombre del programa académico');
            $table->text('descripcion')->nullable()->comment('Descripción del programa');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programas_academicos');
    }
};