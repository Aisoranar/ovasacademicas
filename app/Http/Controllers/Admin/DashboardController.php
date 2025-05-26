<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ova;
use App\Models\User;
use App\Models\Tema;
use App\Models\Actividad;
use App\Models\EvaluacionFinal;
use App\Models\ProgresoActividad;
use App\Models\IntentoEvaluacion;
use App\Models\ProgramaAcademico;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas generales
        $estadisticas = [
            'total_ovas'            => Ova::count(),
            'ovas_activos'          => Ova::where('estado', 'publicado')->count(),
            'total_usuarios'        => User::count(),
            'estudiantes'           => User::where('rol', 'estudiante')->count(),
            'docentes'              => User::where('rol', 'docente')->count(),
            'programas_academicos'  => Ova::whereNotNull('programa_id')->distinct('programa_id')->count('programa_id'),
            'temas'                 => Tema::count(),
            'actividades'           => Actividad::count(),
            'evaluaciones'          => EvaluacionFinal::count(),
        ];

        // OVAs más recientes
        $ovasRecientes = Ova::with(['tema', 'docente'])
            ->latest()
            ->take(5)
            ->get();

        // Usuarios más recientes
        $usuariosRecientes = User::latest()
            ->take(5)
            ->get();

        // Programas académicos con más OVAs
        $programasPopulares = ProgramaAcademico::withCount('ovas')
            ->orderBy('ovas_count', 'desc')
            ->take(5)
            ->get();

        // Temas más utilizados
        $temasPopulares = Tema::withCount('ovas')
            ->orderBy('ovas_count', 'desc')
            ->take(5)
            ->get();

        // Actividad reciente de estudiantes
        $actividadEstudiantes = ProgresoActividad::with(['estudiante', 'actividad.ova'])
            ->where('completada', true)
            ->latest()
            ->take(5)
            ->get();

        // Intentos de evaluación recientes
        $intentosEvaluacion = IntentoEvaluacion::with(['estudiante', 'evaluacionFinal.ova'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'estadisticas',
            'ovasRecientes',
            'usuariosRecientes',
            'programasPopulares',
            'temasPopulares',
            'actividadEstudiantes',
            'intentosEvaluacion'
        ));
    }
}
