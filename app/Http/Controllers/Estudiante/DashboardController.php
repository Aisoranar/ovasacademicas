<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ova;
use App\Models\ProgresoActividad;
use App\Models\IntentoEvaluacion;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // OVAs en los que está inscrito el estudiante
        $ovas = Ova::whereHas('programaAcademico.users', function($query) use ($user) {
            $query->where('users.id', $user->id);
        })
        ->with(['programaAcademico', 'tema'])
        ->where('estado', 'publicado')
        ->latest()
        ->take(5)
        ->get();
        
        // Progreso general
        $estadisticas = [
            'ovas_inscritos' => Ova::whereHas('programaAcademico.users', function($query) use ($user) {
                $query->where('users.id', $user->id);
            })->count(),
            
            'actividades_completadas' => ProgresoActividad::where('user_id', $user->id)
                ->where('completada', true)
                ->count(),
                
            'evaluaciones_completadas' => IntentoEvaluacion::where('user_id', $user->id)
                ->whereNotNull('puntaje_obtenido')
                ->count(),
                
            'promedio_evaluaciones' => IntentoEvaluacion::where('user_id', $user->id)
                ->whereNotNull('puntaje_obtenido')
                ->avg('puntaje_obtenido') ?? 0,
        ];
        
        // Actividades recientes
        $actividadesRecientes = ProgresoActividad::with(['actividad.ova', 'actividad'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
            
        // Evaluaciones recientes
        $evaluacionesRecientes = IntentoEvaluacion::with(['evaluacionFinal.ova'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
        
        return view('estudiante.dashboard', compact(
            'ovas',
            'estadisticas',
            'actividadesRecientes',
            'evaluacionesRecientes'
        ));
    }
} 