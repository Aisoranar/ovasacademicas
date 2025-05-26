<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Models\Ova;
use App\Models\ProgramaAcademico;
use App\Models\Tema;
use App\Models\Etiqueta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class OvaController extends Controller
{
    public function index()
    {
        $ovas = Ova::with(['programaAcademico', 'tema'])
            ->where('docente_id', auth()->id())
            ->withCount(['actividades', 'evaluacionesFinales', 'comentarios'])
            ->latest()
            ->paginate(10);

        return view('docente.ovas.index', compact('ovas'));
    }

    public function create()
    {
        $programas = ProgramaAcademico::where('estado', true)->get();
        $temas = Tema::where('estado', true)->get();
        $etiquetas = Etiqueta::where('estado', true)->get();

        return view('docente.ovas.create', compact('programas', 'temas', 'etiquetas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'objetivos_aprendizaje' => 'required|string',
            'duracion_total' => 'required|integer|min:1',
            'nivel_dificultad' => 'required|in:básico,intermedio,avanzado',
            'programa_academico_id' => 'required|exists:programas_academicos,id',
            'tema_id' => 'required|exists:temas,id',
            'imagen_portada' => 'nullable|image|max:2048',
            'etiquetas' => 'array',
            'etiquetas.*' => 'exists:etiquetas,id'
        ]);

        $validated['slug'] = Str::slug($validated['nombre']);
        $validated['docente_id'] = auth()->id();
        $validated['estado'] = 'borrador';
        $validated['version'] = '1.0';

        if ($request->hasFile('imagen_portada')) {
            $validated['imagen_portada'] = $request->file('imagen_portada')
                ->store('ovas/portadas', 'public');
        }

        $ova = Ova::create($validated);

        if ($request->has('etiquetas')) {
            $ova->etiquetas()->attach($request->etiquetas);
        }

        return redirect()
            ->route('docente.ovas.show', $ova)
            ->with('success', 'OVA creado exitosamente.');
    }

    public function show(Ova $ova)
    {
        $this->authorize('view', $ova);

        $ova->load([
            'programaAcademico',
            'tema',
            'etiquetas',
            'actividades' => function ($query) {
                $query->orderBy('orden');
            },
            'evaluacionesFinales',
            'comentarios' => function ($query) {
                $query->latest();
            }
        ]);

        $estadisticas = [
            'total_actividades' => $ova->actividades()->count(),
            'total_evaluaciones' => $ova->evaluacionesFinales()->count(),
            'total_comentarios' => $ova->comentarios()->count(),
            'total_visualizaciones' => $ova->numero_visualizaciones
        ];

        return view('docente.ovas.show', compact('ova', 'estadisticas'));
    }

    public function edit(Ova $ova)
    {
        $this->authorize('update', $ova);

        $programas = ProgramaAcademico::where('estado', true)->get();
        $temas = Tema::where('estado', true)->get();
        $etiquetas = Etiqueta::where('estado', true)->get();

        return view('docente.ovas.edit', compact('ova', 'programas', 'temas', 'etiquetas'));
    }

    public function update(Request $request, Ova $ova)
    {
        $this->authorize('update', $ova);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'objetivos_aprendizaje' => 'required|string',
            'duracion_total' => 'required|integer|min:1',
            'nivel_dificultad' => 'required|in:básico,intermedio,avanzado',
            'programa_academico_id' => 'required|exists:programas_academicos,id',
            'tema_id' => 'required|exists:temas,id',
            'imagen_portada' => 'nullable|image|max:2048',
            'estado' => 'required|in:borrador,publicado',
            'etiquetas' => 'array',
            'etiquetas.*' => 'exists:etiquetas,id'
        ]);

        if ($request->hasFile('imagen_portada')) {
            // Eliminar imagen anterior si existe
            if ($ova->imagen_portada) {
                Storage::disk('public')->delete($ova->imagen_portada);
            }
            
            $validated['imagen_portada'] = $request->file('imagen_portada')
                ->store('ovas/portadas', 'public');
        }

        $ova->update($validated);

        if ($request->has('etiquetas')) {
            $ova->etiquetas()->sync($request->etiquetas);
        } else {
            $ova->etiquetas()->detach();
        }

        return redirect()
            ->route('docente.ovas.show', $ova)
            ->with('success', 'OVA actualizado exitosamente.');
    }

    public function destroy(Ova $ova)
    {
        $this->authorize('delete', $ova);

        // Eliminar imagen de portada si existe
        if ($ova->imagen_portada) {
            Storage::disk('public')->delete($ova->imagen_portada);
        }

        $ova->delete();

        return redirect()
            ->route('docente.ovas.index')
            ->with('success', 'OVA eliminado exitosamente.');
    }

    public function publicar(Ova $ova)
    {
        $this->authorize('update', $ova);

        // Verificar que tenga al menos una actividad
        if (!$ova->actividades()->exists()) {
            return back()->with('error', 'El OVA debe tener al menos una actividad para ser publicado.');
        }

        // Verificar que tenga una evaluación final
        if (!$ova->evaluacionesFinales()->exists()) {
            return back()->with('error', 'El OVA debe tener una evaluación final para ser publicado.');
        }

        $ova->update([
            'estado' => 'publicado',
            'fecha_publicacion' => now()
        ]);

        return redirect()
            ->route('docente.ovas.show', $ova)
            ->with('success', 'OVA publicado exitosamente.');
    }
} 