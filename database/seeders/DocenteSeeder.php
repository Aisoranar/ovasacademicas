<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ProgramaAcademico;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DocenteSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener los programas necesarios
        $programas = [
            'Ingeniería Informática' => ProgramaAcademico::where('nombre', 'Ingeniería Informática')->first(),
            'Ingeniería de Producción' => ProgramaAcademico::where('nombre', 'Ingeniería de Producción')->first(),
            'Administración de Negocios Internacionales' => ProgramaAcademico::where('nombre', 'Administración de Negocios Internacionales')->first(),
        ];

        // Verificar que todos los programas existan
        foreach ($programas as $nombre => $programa) {
            if (!$programa) {
                $this->command->error("No se encontró el programa: {$nombre}");
                return;
            }
        }

        $docentes = [
            [
                'nombre_completo' => 'Juan Carlos Pérez',
                'identificacion' => '987654321',
                'email' => 'juan.perez@unipaz.edu.co',
                'password' => Hash::make('docente123'),
                'rol' => 'docente',
                'programa_id' => $programas['Ingeniería Informática']->id,
                'departamento_academico' => 'Ciencias de la Ingeniería',
                'tipo_registro' => 'manual',
                'email_verified_at' => now(),
            ],
            [
                'nombre_completo' => 'María Isabel Rodríguez',
                'identificacion' => '456789123',
                'email' => 'maria.rodriguez@unipaz.edu.co',
                'password' => Hash::make('docente123'),
                'rol' => 'docente',
                'programa_id' => $programas['Ingeniería de Producción']->id,
                'departamento_academico' => 'Ciencias de la Ingeniería',
                'tipo_registro' => 'manual',
                'email_verified_at' => now(),
            ],
            [
                'nombre_completo' => 'Carlos Andrés Martínez',
                'identificacion' => '789123456',
                'email' => 'carlos.martinez@unipaz.edu.co',
                'password' => Hash::make('docente123'),
                'rol' => 'docente',
                'programa_id' => $programas['Administración de Negocios Internacionales']->id,
                'departamento_academico' => 'Ciencias Económicas y Administrativas',
                'tipo_registro' => 'manual',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($docentes as $docente) {
            User::create($docente);
        }

        $this->command->info('Docentes creados exitosamente.');
    }
} 