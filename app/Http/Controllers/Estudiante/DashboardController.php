<?php
// C:\laragon\www\ovasacademicas\app\Http\Controllers\Estudiante\DashboardController.php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ova;
use App\Models\ProgresoActividad;
use App\Models\IntentoEvaluacion;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:estudiante']);
    }

    public function index()
    {
        $user = Auth::user();

        // OVAs en los que está inscrito el estudiante
        $ovas = Ova::whereHas('programaAcademico.users', function($query) use ($user) {
                $query->where('users.id', $user->id);
            })
            ->where('estado', 'publicado')
            ->with(['programaAcademico', 'tema'])
            ->latest()
            ->take(5)
            ->get();

        // Progreso general
        $estadisticas = [
            'ovas_inscritos' => Ova::whereHas('programaAcademico.users', function($query) use ($user) {
                    $query->where('users.id', $user->id);
                })
                ->where('estado', 'publicado')
                ->count(),

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
        $actividadesRecientes = ProgresoActividad::with('actividad.ova')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Evaluaciones recientes
        $evaluacionesRecientes = IntentoEvaluacion::with('evaluacionFinal.ova')
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
