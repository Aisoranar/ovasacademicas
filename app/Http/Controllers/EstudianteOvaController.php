<?php

namespace App\Http\Controllers;

use App\Models\Ova;
use Illuminate\Http\Request;

class EstudianteOvaController extends Controller
{
    /**
     * Display a listing of available OVAs.
     */
    public function index()
    {
        $ovas = Ova::where('estado', 'publicado')
            ->with(['docente', 'tema', 'etiquetas'])
            ->latest()
            ->paginate(12);

        return view('estudiante.ovas.index', compact('ovas'));
    }

    /**
     * Display the specified OVA.
     */
    public function show(Ova $ova)
    {
        // Verificar que el OVA esté publicado
        if ($ova->estado !== 'publicado') {
            abort(404);
        }

        $ova->load(['docente', 'tema', 'etiquetas', 'actividades']);

        return view('estudiante.ovas.show', compact('ova'));
    }

    /**
     * Display a listing of OVAs that the student has started.
     */
    public function misOvas()
    {
        $ovas = auth()->user()
            ->progresoActividades()
            ->with(['actividad.ova'])
            ->get()
            ->pluck('actividad.ova')
            ->unique('id')
            ->values();

        return view('estudiante.ovas.mis-ovas', compact('ovas'));
    }
} 