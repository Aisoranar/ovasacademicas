<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Etiqueta;
use Illuminate\Validation\Rule;

class EtiquetaController extends Controller
{
    public function index()
    {
        $etiquetas = Etiqueta::withCount('ovas')
            ->latest()
            ->paginate(10);
            
        return view('admin.etiquetas.index', compact('etiquetas'));
    }
    
    public function create()
    {
        return view('admin.etiquetas.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:50|unique:etiquetas',
            'descripcion' => 'nullable|string',
            'color' => 'required|string|max:7|regex:/^#[0-9A-F]{6}$/i',
            'estado' => 'boolean',
        ]);
        
        $etiqueta = Etiqueta::create($validated);
        
        return redirect()
            ->route('admin.etiquetas.show', $etiqueta)
            ->with('success', 'Etiqueta creada exitosamente.');
    }
    
    public function show(Etiqueta $etiqueta)
    {
        // Cargar OVAs asociados con estadísticas
        $ovas = $etiqueta->ovas()
            ->with(['docente', 'programaAcademico', 'tema'])
            ->withCount(['actividades', 'evaluacionesFinales', 'comentarios'])
            ->latest()
            ->paginate(10);
            
        return view('admin.etiquetas.show', compact('etiqueta', 'ovas'));
    }
    
    public function edit(Etiqueta $etiqueta)
    {
        return view('admin.etiquetas.edit', compact('etiqueta'));
    }
    
    public function update(Request $request, Etiqueta $etiqueta)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:50', Rule::unique('etiquetas')->ignore($etiqueta->id)],
            'descripcion' => 'nullable|string',
            'color' => 'required|string|max:7|regex:/^#[0-9A-F]{6}$/i',
            'estado' => 'boolean',
        ]);
        
        $etiqueta->update($validated);
        
        return redirect()
            ->route('admin.etiquetas.show', $etiqueta)
            ->with('success', 'Etiqueta actualizada exitosamente.');
    }
    
    public function destroy(Etiqueta $etiqueta)
    {
        // Eliminar relaciones con OVAs
        $etiqueta->ovas()->detach();
        
        $etiqueta->delete();
        
        return redirect()
            ->route('admin.etiquetas.index')
            ->with('success', 'Etiqueta eliminada exitosamente.');
    }
} 