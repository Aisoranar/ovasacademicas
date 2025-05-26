<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ProgramaAcademico;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Buscar el programa por nombre
        $programa = ProgramaAcademico::where('nombre', 'Administración de Negocios Internacionales')->first();

        if (!$programa) {
            $this->command->error('No se encontró el programa Administración de Negocios Internacionales');
            return;
        }

        DB::table('users')->insert([
            'nombre_completo' => 'Administrador Sistema',
            'identificacion' => '123456789',
            'email' => 'admin@unipaz.edu.co',
            'password' => Hash::make('admin123'),
            'rol' => 'admin',
            'programa_id' => $programa->id,
            'departamento_academico' => 'Ciencias Económicas y Administrativas',
            'tipo_registro' => 'manual',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('Administrador creado exitosamente.');
    }
} 