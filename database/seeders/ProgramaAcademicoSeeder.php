<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramaAcademico;

class ProgramaAcademicoSeeder extends Seeder
{
    public function run(): void
    {
        $programas = [
            [
                'nombre' => 'Administración de Negocios Internacionales',
                'descripcion' => 'Programa enfocado en la gestión de negocios internacionales'
            ],
            [
                'nombre' => 'Ingeniería Informática',
                'descripcion' => 'Programa enfocado en el desarrollo de software y sistemas informáticos'
            ],
            [
                'nombre' => 'Licenciatura en Artes',
                'descripcion' => 'Programa enfocado en las artes y la expresión creativa'
            ],
            [
                'nombre' => 'Química',
                'descripcion' => 'Programa enfocado en el estudio de la química y sus aplicaciones'
            ],
            [
                'nombre' => 'Comunicación Social',
                'descripcion' => 'Programa enfocado en la comunicación y el periodismo'
            ],
            [
                'nombre' => 'Trabajo Social',
                'descripcion' => 'Programa enfocado en el trabajo social y la intervención comunitaria'
            ],
            [
                'nombre' => 'Derecho',
                'descripcion' => 'Programa enfocado en el estudio del derecho y la justicia'
            ],
            [
                'nombre' => 'Técnico en Extracción de Biomasa Enérgetica - Modalidad presencial',
                'descripcion' => 'Programa técnico enfocado en la extracción de biomasa energética'
            ],
            [
                'nombre' => 'Tecnología en Procesamiento de Alimentos - Modalidad a distancia',
                'descripcion' => 'Programa tecnológico enfocado en el procesamiento de alimentos'
            ],
            [
                'nombre' => 'Ingeniería Agroindustrial',
                'descripcion' => 'Programa enfocado en la ingeniería aplicada a la agroindustria'
            ],
            [
                'nombre' => 'Ingeniería Agronómica',
                'descripcion' => 'Programa enfocado en la ingeniería aplicada a la agronomía'
            ],
            [
                'nombre' => 'Ingeniería Civil',
                'descripcion' => 'Programa enfocado en la ingeniería civil y la construcción'
            ],
            [
                'nombre' => 'Tecnología en Obras Civiles',
                'descripcion' => 'Programa tecnológico enfocado en obras civiles'
            ],
            [
                'nombre' => 'Ingeniería Ambiental y de Saneamiento',
                'descripcion' => 'Programa enfocado en la ingeniería ambiental y el saneamiento'
            ],
            [
                'nombre' => 'Tecnología en Operación de Sistemas Electromecánicos',
                'descripcion' => 'Programa tecnológico enfocado en sistemas electromecánicos'
            ],
            [
                'nombre' => 'Tecnología en Seguridad y Salud en el Trabajo',
                'descripcion' => 'Programa tecnológico enfocado en seguridad y salud laboral'
            ],
            [
                'nombre' => 'Ingeniería de Producción',
                'descripcion' => 'Programa enfocado en la ingeniería de producción industrial'
            ],
            [
                'nombre' => 'Ingeniería en Seguridad y Salud en el Trabajo',
                'descripcion' => 'Programa enfocado en la ingeniería de seguridad y salud laboral'
            ],
            [
                'nombre' => 'Medicina Veterinaria y Zootecnia',
                'descripcion' => 'Programa enfocado en la medicina veterinaria y la zootecnia'
            ]
        ];

        foreach ($programas as $programa) {
            ProgramaAcademico::create($programa);
        }
    }
} 