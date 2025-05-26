<?php

namespace App\Traits;

trait HasEnumValues
{
    public static function getEnumValues($column)
    {
        $instance = new static;
        $enumValues = [];

        switch ($column) {
            case 'programa_academico':
                $enumValues = [
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
                ];
                break;
            case 'departamento_academico':
                $enumValues = [
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
                ];
                break;
            case 'rol':
                $enumValues = ['admin', 'docente', 'estudiante'];
                break;
        }

        return $enumValues;
    }
} 