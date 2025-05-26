<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ova;
use App\Models\Actividad;
use App\Models\RecursoActividad;
use Illuminate\Support\Facades\Storage;

class ActividadController extends Controller
{
    public function index(Ova $ova)
    {
        $this->authorize('view', $ova);
        
        $actividades = $ova->actividades()
            ->withCount(['progresos', 'recursos'])
            ->orderBy('orden')
            ->paginate(10);
            
        return view('docente.actividades.index', compact('ova', 'actividades'));
    }
    
    public function create(Ova $ova)
    {
        $this->authorize('update', $ova);
        
        return view('docente.actividades.create', compact('ova'));
    }
    
    public function store(Request $request, Ova $ova)
    {
        $this->authorize('update', $ova);
        
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'tipo_actividad' => ['required', Rule::in(['lectura', 'ejercicio', 'quiz', 'video', 'otro'])],
            'instrucciones' => 'required|string',
            'tiempo_estimado' => 'required|integer|min:1',
            'puntaje_maximo' => 'required|integer|min:0',
            'orden' => 'required|integer|min:1',
            'estado' => 'boolean',
            'recursos' => 'array',
            'recursos.*.titulo' => 'required|string|max:255',
            'recursos.*.tipo_recurso' => ['required', Rule::in(['documento', 'imagen', 'video', 'audio', 'enlace', 'otro'])],
            'recursos.*.url_recurso' => 'required|string|max:255',
            'recursos.*.descripcion' => 'nullable|string',
            'recursos.*.orden' => 'required|integer|min:1',
        ]);
        
        // Crear la actividad
        $actividad = $ova->actividades()->create([
            'titulo' => $validated['titulo'],
            'descripcion' => $validated['descripcion'],
            'tipo_actividad' => $validated['tipo_actividad'],
            'instrucciones' => $validated['instrucciones'],
            'tiempo_estimado' => $validated['tiempo_estimado'],
            'puntaje_maximo' => $validated['puntaje_maximo'],
            'orden' => $validated['orden'],
            'estado' => $validated['estado'],
        ]);
        
        // Crear los recursos asociados
        if (!empty($validated['recursos'])) {
            foreach ($validated['recursos'] as $recurso) {
                $actividad->recursos()->create([
                    'titulo' => $recurso['titulo'],
                    'tipo_recurso' => $recurso['tipo_recurso'],
                    'url_recurso' => $recurso['url_recurso'],
                    'descripcion' => $recurso['descripcion'] ?? null,
                    'orden' => $recurso['orden'],
                    'estado' => true,
                ]);
            }
        }
        
        return redirect()
            ->route('docente.ovas.actividades.show', [$ova, $actividad])
            ->with('success', 'Actividad creada exitosamente.');
    }
    
    public function show(Ova $ova, Actividad $actividad)
    {
        $this->authorize('view', $ova);
        
        $actividad->load(['recursos', 'progresos.estudiante']);
        
        // Cargar estadísticas de progreso
        $estadisticas = [
            'total_estudiantes' => $ova->programaAcademico->estudiantes()->count(),
            'completados' => $actividad->progresos()->where('completada', true)->count(),
            'promedio_puntaje' => $actividad->progresos()->whereNotNull('puntaje_obtenido')->avg('puntaje_obtenido') ?? 0,
            'tiempo_promedio' => $actividad->progresos()
                ->whereNotNull('tiempo_fin')
                ->get()
                ->avg(function($progreso) {
                    return $progreso->tiempo_fin->diffInSeconds($progreso->tiempo_inicio);
                }) ?? 0,
        ];
        
        return view('docente.actividades.show', compact('ova', 'actividad', 'estadisticas'));
    }
    
    public function edit(Ova $ova, Actividad $actividad)
    {
        $this->authorize('update', $ova);
        
        $actividad->load('recursos');
        return view('docente.actividades.edit', compact('ova', 'actividad'));
    }
    
    public function update(Request $request, Ova $ova, Actividad $actividad)
    {
        $this->authorize('update', $ova);
        
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'tipo_actividad' => ['required', Rule::in(['lectura', 'ejercicio', 'quiz', 'video', 'otro'])],
            'instrucciones' => 'required|string',
            'tiempo_estimado' => 'required|integer|min:1',
            'puntaje_maximo' => 'required|integer|min:0',
            'orden' => 'required|integer|min:1',
            'estado' => 'boolean',
            'recursos' => 'array',
            'recursos.*.id' => 'nullable|exists:recursos_actividad,id',
            'recursos.*.titulo' => 'required|string|max:255',
            'recursos.*.tipo_recurso' => ['required', Rule::in(['documento', 'imagen', 'video', 'audio', 'enlace', 'otro'])],
            'recursos.*.url_recurso' => 'required|string|max:255',
            'recursos.*.descripcion' => 'nullable|string',
            'recursos.*.orden' => 'required|integer|min:1',
            'recursos.*.estado' => 'boolean',
            'recursos_eliminar' => 'array',
            'recursos_eliminar.*' => 'exists:recursos_actividad,id',
        ]);
        
        // Actualizar la actividad
        $actividad->update([
            'titulo' => $validated['titulo'],
            'descripcion' => $validated['descripcion'],
            'tipo_actividad' => $validated['tipo_actividad'],
            'instrucciones' => $validated['instrucciones'],
            'tiempo_estimado' => $validated['tiempo_estimado'],
            'puntaje_maximo' => $validated['puntaje_maximo'],
            'orden' => $validated['orden'],
            'estado' => $validated['estado'],
        ]);
        
        // Eliminar recursos marcados para eliminar
        if (!empty($validated['recursos_eliminar'])) {
            $actividad->recursos()->whereIn('id', $validated['recursos_eliminar'])->delete();
        }
        
        // Actualizar o crear recursos
        if (!empty($validated['recursos'])) {
            foreach ($validated['recursos'] as $recurso) {
                if (isset($recurso['id'])) {
                    // Actualizar recurso existente
                    $actividad->recursos()->where('id', $recurso['id'])->update([
                        'titulo' => $recurso['titulo'],
                        'tipo_recurso' => $recurso['tipo_recurso'],
                        'url_recurso' => $recurso['url_recurso'],
                        'descripcion' => $recurso['descripcion'] ?? null,
                        'orden' => $recurso['orden'],
                        'estado' => $recurso['estado'],
                    ]);
                } else {
                    // Crear nuevo recurso
                    $actividad->recursos()->create([
                        'titulo' => $recurso['titulo'],
                        'tipo_recurso' => $recurso['tipo_recurso'],
                        'url_recurso' => $recurso['url_recurso'],
                        'descripcion' => $recurso['descripcion'] ?? null,
                        'orden' => $recurso['orden'],
                        'estado' => true,
                    ]);
                }
            }
        }
        
        return redirect()
            ->route('docente.ovas.actividades.show', [$ova, $actividad])
            ->with('success', 'Actividad actualizada exitosamente.');
    }
    
    public function destroy(Ova $ova, Actividad $actividad)
    {
        $this->authorize('update', $ova);
        
        if ($actividad->progresos()->exists()) {
            return back()->with('error', 'No se puede eliminar la actividad porque tiene progreso registrado.');
        }
        
        // Eliminar recursos asociados
        $actividad->recursos()->delete();
        
        $actividad->delete();
        
        return redirect()
            ->route('docente.ovas.actividades.index', $ova)
            ->with('success', 'Actividad eliminada exitosamente.');
    }
} 