<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ova;
use App\Models\Actividad;
use App\Models\EvaluacionFinal;
use App\Models\ProgresoActividad;
use App\Models\IntentoEvaluacion;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // OVAs del docente
        $ovas = Ova::where('docente_id', $user->id)
            ->with(['programaAcademico', 'tema'])
            ->latest()
            ->take(5)
            ->get();
        
        // Estadísticas generales
        $estadisticas = [
            'total_ovas' => Ova::where('docente_id', $user->id)->count(),
            'ovas_publicados' => Ova::where('docente_id', $user->id)
                ->where('estado', 'publicado')
                ->count(),
            'total_actividades' => Actividad::whereHas('ova', function($query) use ($user) {
                $query->where('docente_id', $user->id);
            })->count(),
            'total_evaluaciones' => EvaluacionFinal::whereHas('ova', function($query) use ($user) {
                $query->where('docente_id', $user->id);
            })->count(),
        ];
        
        // Actividades más recientes
        $actividadesRecientes = Actividad::whereHas('ova', function($query) use ($user) {
                $query->where('docente_id', $user->id);
            })
            ->with(['ova', 'progresos' => function($query) {
                $query->latest()->take(5);
            }])
            ->latest()
            ->take(5)
            ->get();
            
        // Evaluaciones más recientes
        $evaluacionesRecientes = EvaluacionFinal::whereHas('ova', function($query) use ($user) {
                $query->where('docente_id', $user->id);
            })
            ->with(['ova', 'intentos' => function($query) {
                $query->latest()->take(5);
            }])
            ->latest()
            ->take(5)
            ->get();
            
        // Progreso de estudiantes
        $progresoEstudiantes = ProgresoActividad::whereHas('actividad.ova', function($query) use ($user) {
                $query->where('docente_id', $user->id);
            })
            ->with(['estudiante', 'actividad.ova'])
            ->where('completada', true)
            ->latest()
            ->take(5)
            ->get();
            
        // Intentos de evaluación
        $intentosEvaluacion = IntentoEvaluacion::whereHas('evaluacionFinal.ova', function($query) use ($user) {
                $query->where('docente_id', $user->id);
            })
            ->with(['estudiante', 'evaluacionFinal.ova'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('docente.dashboard', compact(
            'ovas',
            'estadisticas',
            'actividadesRecientes',
            'evaluacionesRecientes',
            'progresoEstudiantes',
            'intentosEvaluacion'
        ));
    }
} 