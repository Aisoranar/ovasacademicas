<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ova;
use App\Models\Actividad;
use App\Models\ProgresoActividad;

class EstudianteDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:estudiante']);
    }

    public function index()
    {
        $user = auth()->user();
        
        // Obtener OVAs disponibles para el programa académico del estudiante
        $ovas = Ova::whereHas('programa', function ($query) use ($user) {
                $query->where('id', $user->programa_id);
            })
            ->where('estado', 'publicado')
            ->with(['actividades', 'tema'])
            ->latest()
            ->take(5)
            ->get();

        // Obtener actividades en progreso del estudiante (no completadas)
        $actividadesEnProgreso = ProgresoActividad::where('user_id', $user->id)
                                                 ->where('completada', false)
                                                 ->with(['actividad.ova'])
                                                 ->latest()
                                                 ->take(5)
                                                 ->get();

        // Obtener actividades completadas
        $actividadesCompletadas = ProgresoActividad::where('user_id', $user->id)
                                                  ->where('completada', true)
                                                  ->with(['actividad.ova'])
                                                  ->latest()
                                                  ->take(5)
                                                  ->get();

        return view('estudiante.dashboard', compact('ovas', 'actividadesEnProgreso', 'actividadesCompletadas'));
    }
} 