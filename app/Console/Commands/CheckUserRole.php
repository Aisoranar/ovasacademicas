<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CheckUserRole extends Command
{
    protected $signature = 'user:check-role {email}';
    protected $description = 'Check a user\'s role by email';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found.");
            return 1;
        }

        $this->info("User details for {$email}:");
        $this->table(
            ['ID', 'Name', 'Email', 'Role', 'Programa Académico', 'Tipo Registro'],
            [[
                $user->id,
                $user->nombre_completo,
                $user->email,
                $user->rol,
                $user->programa_academico,
                $user->tipo_registro
            ]]
        );

        return 0;
    }
} 