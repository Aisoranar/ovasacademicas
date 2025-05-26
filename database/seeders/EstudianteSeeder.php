<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ProgramaAcademico;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EstudianteSeeder extends Seeder
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

        $estudiantes = [
            [
                'nombre_completo' => 'Ana María López',
                'identificacion' => '1234567890',
                'email' => 'ana.lopez@unipaz.edu.co',
                'password' => Hash::make('estudiante123'),
                'rol' => 'estudiante',
                'programa_id' => $programas['Ingeniería Informática']->id,
                'departamento_academico' => 'Ciencias de la Ingeniería',
                'semestre_actual' => '6',
                'tipo_registro' => 'email',
                'email_verified_at' => now(),
            ],
            [
                'nombre_completo' => 'Pedro José Ramírez',
                'identificacion' => '2345678901',
                'email' => 'pedro.ramirez@unipaz.edu.co',
                'password' => Hash::make('estudiante123'),
                'rol' => 'estudiante',
                'programa_id' => $programas['Ingeniería de Producción']->id,
                'departamento_academico' => 'Ciencias de la Ingeniería',
                'semestre_actual' => '4',
                'tipo_registro' => 'email',
                'email_verified_at' => now(),
            ],
            [
                'nombre_completo' => 'Laura Sofía Gómez',
                'identificacion' => '3456789012',
                'email' => 'laura.gomez@unipaz.edu.co',
                'password' => Hash::make('estudiante123'),
                'rol' => 'estudiante',
                'programa_id' => $programas['Administración de Negocios Internacionales']->id,
                'departamento_academico' => 'Ciencias Económicas y Administrativas',
                'semestre_actual' => '8',
                'tipo_registro' => 'email',
                'email_verified_at' => now(),
            ],
            [
                'nombre_completo' => 'David Alejandro Torres',
                'identificacion' => '4567890123',
                'email' => 'david.torres@unipaz.edu.co',
                'password' => Hash::make('estudiante123'),
                'rol' => 'estudiante',
                'programa_id' => $programas['Ingeniería Informática']->id,
                'departamento_academico' => 'Ciencias de la Ingeniería',
                'semestre_actual' => '2',
                'tipo_registro' => 'email',
                'email_verified_at' => now(),
            ],
            [
                'nombre_completo' => 'María Camila Sánchez',
                'identificacion' => '5678901234',
                'email' => 'maria.sanchez@unipaz.edu.co',
                'password' => Hash::make('estudiante123'),
                'rol' => 'estudiante',
                'programa_id' => $programas['Ingeniería de Producción']->id,
                'departamento_academico' => 'Ciencias de la Ingeniería',
                'semestre_actual' => '10',
                'tipo_registro' => 'email',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($estudiantes as $estudiante) {
            User::create($estudiante);
        }

        $this->command->info('Estudiantes creados exitosamente.');
    }
} 