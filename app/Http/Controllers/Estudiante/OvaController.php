<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ova;
use App\Models\ProgresoActividad;

class OvaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:estudiante']);
    }

    /**
     * Display a listing of available OVAs for the student.
     */
    public function index()
    {
        $ovas = Ova::with(['tema', 'actividades'])
            ->whereHas('programa', function ($query) {
                $query->where('programa_id', auth()->user()->programa_id);
            })
            ->withCount('actividades')
            ->paginate(9);

        return view('estudiante.ovas.index', compact('ovas'));
    }

    /**
     * Display the specified OVA.
     */
    public function show(Ova $ova)
    {
        // Verify that the student has access to this OVA
        if ($ova->programa_id !== auth()->user()->programa_id) {
            abort(403, 'No tienes acceso a este OVA.');
        }

        // Load relationships
        $ova->load([
            'tema',
            'actividades' => function ($query) {
                $query->orderBy('orden');
            },
            'actividades.progreso' => function ($query) {
                $query->where('user_id', auth()->id());
            },
            'threads' => function ($query) {
                $query->withCount('replies')
                    ->with('user:id,nombre_completo')
                    ->latest();
            }
        ]);

        return view('estudiante.ovas.show', compact('ova'));
    }

    /**
     * Display the student's enrolled OVAs.
     */
    public function misOvas()
    {
        $user = auth()->user();
        
        // Obtener OVAs en los que el estudiante tiene progreso
        $ovas = Ova::whereHas('actividades.progreso', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('programa_academico', $user->programa_academico)
            ->where('estado', 'publicado')
            ->with(['tema', 'actividades' => function($query) use ($user) {
                $query->with(['progreso' => function($q) use ($user) {
                    $q->where('user_id', $user->id);
                }]);
            }])
            ->latest()
            ->paginate(10);
            
        return view('estudiante.ovas.mis-ovas', compact('ovas'));
    }
} 