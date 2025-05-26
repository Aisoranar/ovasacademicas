<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tema;
use App\Models\ProgramaAcademico;

class TemaController extends Controller
{
    public function index()
    {
        $temas = Tema::with(['programaAcademico'])
            ->withCount('ovas')
            ->latest()
            ->paginate(10);
            
        return view('admin.temas.index', compact('temas'));
    }
    
    public function create()
    {
        $programas = ProgramaAcademico::where('estado', true)->get();
        return view('admin.temas.create', compact('programas'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'programa_academico_id' => 'required|exists:programas_academicos,id',
            'estado' => 'boolean',
        ]);
        
        $tema = Tema::create($validated);
        
        return redirect()
            ->route('admin.temas.show', $tema)
            ->with('success', 'Tema creado exitosamente.');
    }
    
    public function show(Tema $tema)
    {
        $tema->load(['programaAcademico']);
        
        // Cargar OVAs asociados con estadísticas
        $ovas = $tema->ovas()
            ->with(['docente', 'programaAcademico'])
            ->withCount(['actividades', 'evaluacionesFinales', 'comentarios'])
            ->latest()
            ->paginate(10);
            
        return view('admin.temas.show', compact('tema', 'ovas'));
    }
    
    public function edit(Tema $tema)
    {
        $programas = ProgramaAcademico::where('estado', true)->get();
        return view('admin.temas.edit', compact('tema', 'programas'));
    }
    
    public function update(Request $request, Tema $tema)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'programa_academico_id' => 'required|exists:programas_academicos,id',
            'estado' => 'boolean',
        ]);
        
        $tema->update($validated);
        
        return redirect()
            ->route('admin.temas.show', $tema)
            ->with('success', 'Tema actualizado exitosamente.');
    }
    
    public function destroy(Tema $tema)
    {
        if ($tema->ovas()->exists()) {
            return back()->with('error', 'No se puede eliminar el tema porque tiene OVAs asociados.');
        }
        
        $tema->delete();
        
        return redirect()
            ->route('admin.temas.index')
            ->with('success', 'Tema eliminado exitosamente.');
    }
} 