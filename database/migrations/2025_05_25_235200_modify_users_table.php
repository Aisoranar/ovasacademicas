<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cambiar programa_academico de enum a string
            $table->string('programa_academico')->nullable()->change();
            
            // Agregar columna semestre_actual
            $table->unsignedTinyInteger('semestre_actual')->nullable()->comment('Semestre actual del estudiante (1-10)');

            // Cambiar departamento_academico de string a enum
            $table->enum('departamento_academico', [
                'Administración de Negocios',
                'Ingeniería',
                'Ciencias Sociales y Humanidades',
                'Ciencias Básicas',
                'Ciencias de la Salud',
                'Ciencias Agrarias',
                'Ciencias de la Educación',
                'Ciencias Económicas y Administrativas',
                'Ciencias Jurídicas y Políticas',
                'Ciencias de la Comunicación',
                'Ciencias Ambientales',
                'Ciencias de la Ingeniería',
                'Ciencias de la Salud Ocupacional',
                'Ciencias Veterinarias'
            ])->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revertir cambios
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
            ])->nullable()->change();
            
            $table->dropColumn('semestre_actual');

            // Revertir departamento_academico a string
            $table->string('departamento_academico')->nullable()->change();
        });
    }
}; 