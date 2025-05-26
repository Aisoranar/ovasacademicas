<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo')->nullable();
            $table->string('identificacion')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('rol', ['admin', 'docente', 'estudiante']);
            $table->enum('programa_academico', [
                'Administración de Negocios Internacionales',
                'Ingeniería Informática',
                'Licenciatura en Artes',
                'Química',
                'Comunicación Social',
                'Trabajo Social',
                'Derecho',
                'Técnico en Extracción de Biomasa Enérgetica - Modalidad presencial',
                'Tecnología en Procesamiento de Alimentos - Modalidad a distancia',
                'Ingeniería Agroindustrial',
                'Ingeniería Agronómica',
                'Ingeniería Civil',
                'Tecnología en Obras Civiles',
                'Ingeniería Ambiental y de Saneamiento',
                'Tecnología en Operación de Sistemas Electromecánicos',
                'Tecnología en Seguridad y Salud en el Trabajo',
                'Ingeniería de Producción',
                'Ingeniería en Seguridad y Salud en el Trabajo',
                'Medicina Veterinaria y Zootecnia',
            ])->nullable()->comment('Programa académico del usuario');
            $table->string('departamento_academico')->nullable()->comment('Departamento académico');
            $table->enum('tipo_registro', ['email','oauth','manual'])
                  ->default('email')
                  ->comment('Método de registro: email, oauth, manual');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};