<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ova;
use App\Models\EvaluacionFinal;
use App\Models\Pregunta;
use App\Models\OpcionRespuesta;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EvaluacionFinalController extends Controller
{
    public function index(Ova $ova)
    {
        $this->authorize('view', $ova);
        
        $evaluaciones = $ova->evaluacionesFinales()
            ->withCount(['preguntas', 'intentos'])
            ->latest()
            ->paginate(10);
            
        return view('docente.evaluaciones.index', compact('ova', 'evaluaciones'));
    }
    
    public function create(Ova $ova)
    {
        $this->authorize('update', $ova);
        
        return view('docente.evaluaciones.create', compact('ova'));
    }
    
    public function store(Request $request, Ova $ova)
    {
        $this->authorize('update', $ova);
        
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'tiempo_limite' => 'required|integer|min:1',
            'puntaje_aprobacion' => 'required|integer|min:0',
            'numero_intentos' => 'required|integer|min:1',
            'estado' => 'boolean',
            'preguntas' => 'required|array|min:1',
            'preguntas.*.enunciado' => 'required|string',
            'preguntas.*.tipo_pregunta' => ['required', Rule::in(['opcion_unica', 'opcion_multiple', 'verdadero_falso', 'respuesta_abierta'])],
            'preguntas.*.puntaje' => 'required|integer|min:1',
            'preguntas.*.orden' => 'required|integer|min:1',
            'preguntas.*.opciones' => 'required_if:preguntas.*.tipo_pregunta,opcion_unica,opcion_multiple,verdadero_falso|array',
            'preguntas.*.opciones.*.texto' => 'required|string',
            'preguntas.*.opciones.*.es_correcta' => 'required|boolean',
            'preguntas.*.opciones.*.orden' => 'required|integer|min:1',
            'preguntas.*.respuesta_correcta' => 'required_if:preguntas.*.tipo_pregunta,respuesta_abierta|string',
        ]);
        
        try {
            DB::beginTransaction();
            
            // Crear la evaluación
            $evaluacion = $ova->evaluacionesFinales()->create([
                'titulo' => $validated['titulo'],
                'descripcion' => $validated['descripcion'],
                'tiempo_limite' => $validated['tiempo_limite'],
                'puntaje_aprobacion' => $validated['puntaje_aprobacion'],
                'numero_intentos' => $validated['numero_intentos'],
                'estado' => $validated['estado'],
            ]);
            
            // Crear las preguntas y opciones
            foreach ($validated['preguntas'] as $preguntaData) {
                $pregunta = $evaluacion->preguntas()->create([
                    'enunciado' => $preguntaData['enunciado'],
                    'tipo_pregunta' => $preguntaData['tipo_pregunta'],
                    'puntaje' => $preguntaData['puntaje'],
                    'orden' => $preguntaData['orden'],
                    'respuesta_correcta' => $preguntaData['respuesta_correcta'] ?? null,
                ]);
                
                // Crear las opciones si es necesario
                if (in_array($preguntaData['tipo_pregunta'], ['opcion_unica', 'opcion_multiple', 'verdadero_falso'])) {
                    foreach ($preguntaData['opciones'] as $opcionData) {
                        $pregunta->opcionesRespuesta()->create([
                            'texto' => $opcionData['texto'],
                            'es_correcta' => $opcionData['es_correcta'],
                            'orden' => $opcionData['orden'],
                        ]);
                    }
                }
            }
            
            DB::commit();
            
            return redirect()
                ->route('docente.ovas.evaluaciones.show', [$ova, $evaluacion])
                ->with('success', 'Evaluación creada exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al crear la evaluación: ' . $e->getMessage());
        }
    }
    
    public function show(Ova $ova, EvaluacionFinal $evaluacion)
    {
        $this->authorize('view', $ova);
        
        $evaluacion->load(['preguntas.opcionesRespuesta', 'intentos.estudiante']);
        
        // Cargar estadísticas
        $estadisticas = [
            'total_estudiantes' => $ova->programaAcademico->estudiantes()->count(),
            'intentos_totales' => $evaluacion->intentos()->count(),
            'aprobados' => $evaluacion->intentos()
                ->whereNotNull('puntaje_obtenido')
                ->where('puntaje_obtenido', '>=', $evaluacion->puntaje_aprobacion)
                ->count(),
            'promedio_puntaje' => $evaluacion->intentos()
                ->whereNotNull('puntaje_obtenido')
                ->avg('puntaje_obtenido') ?? 0,
            'tiempo_promedio' => $evaluacion->intentos()
                ->whereNotNull('tiempo_fin')
                ->get()
                ->avg(function($intento) {
                    return $intento->tiempo_fin->diffInSeconds($intento->tiempo_inicio);
                }) ?? 0,
        ];
        
        // Estadísticas por pregunta
        $estadisticasPreguntas = $evaluacion->preguntas->map(function($pregunta) {
            $totalRespuestas = $pregunta->intentosRespuesta()->count();
            $respuestasCorrectas = $pregunta->intentosRespuesta()
                ->where('es_correcta', true)
                ->count();
                
            return [
                'id' => $pregunta->id,
                'enunciado' => $pregunta->enunciado,
                'total_respuestas' => $totalRespuestas,
                'respuestas_correctas' => $respuestasCorrectas,
                'porcentaje_correcto' => $totalRespuestas > 0 
                    ? round(($respuestasCorrectas / $totalRespuestas) * 100, 2)
                    : 0,
            ];
        });
        
        return view('docente.evaluaciones.show', compact(
            'ova',
            'evaluacion',
            'estadisticas',
            'estadisticasPreguntas'
        ));
    }
    
    public function edit(Ova $ova, EvaluacionFinal $evaluacion)
    {
        $this->authorize('update', $ova);
        
        $evaluacion->load(['preguntas.opcionesRespuesta']);
        return view('docente.evaluaciones.edit', compact('ova', 'evaluacion'));
    }
    
    public function update(Request $request, Ova $ova, EvaluacionFinal $evaluacion)
    {
        $this->authorize('update', $ova);
        
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'tiempo_limite' => 'required|integer|min:1',
            'puntaje_aprobacion' => 'required|integer|min:0',
            'numero_intentos' => 'required|integer|min:1',
            'estado' => 'boolean',
            'preguntas' => 'required|array|min:1',
            'preguntas.*.id' => 'nullable|exists:preguntas,id',
            'preguntas.*.enunciado' => 'required|string',
            'preguntas.*.tipo_pregunta' => ['required', Rule::in(['opcion_unica', 'opcion_multiple', 'verdadero_falso', 'respuesta_abierta'])],
            'preguntas.*.puntaje' => 'required|integer|min:1',
            'preguntas.*.orden' => 'required|integer|min:1',
            'preguntas.*.opciones' => 'required_if:preguntas.*.tipo_pregunta,opcion_unica,opcion_multiple,verdadero_falso|array',
            'preguntas.*.opciones.*.id' => 'nullable|exists:opciones_respuesta,id',
            'preguntas.*.opciones.*.texto' => 'required|string',
            'preguntas.*.opciones.*.es_correcta' => 'required|boolean',
            'preguntas.*.opciones.*.orden' => 'required|integer|min:1',
            'preguntas.*.respuesta_correcta' => 'required_if:preguntas.*.tipo_pregunta,respuesta_abierta|string',
            'preguntas_eliminar' => 'array',
            'preguntas_eliminar.*' => 'exists:preguntas,id',
            'opciones_eliminar' => 'array',
            'opciones_eliminar.*' => 'exists:opciones_respuesta,id',
        ]);
        
        try {
            DB::beginTransaction();
            
            // Actualizar la evaluación
            $evaluacion->update([
                'titulo' => $validated['titulo'],
                'descripcion' => $validated['descripcion'],
                'tiempo_limite' => $validated['tiempo_limite'],
                'puntaje_aprobacion' => $validated['puntaje_aprobacion'],
                'numero_intentos' => $validated['numero_intentos'],
                'estado' => $validated['estado'],
            ]);
            
            // Eliminar preguntas marcadas para eliminar
            if (!empty($validated['preguntas_eliminar'])) {
                $evaluacion->preguntas()->whereIn('id', $validated['preguntas_eliminar'])->delete();
            }
            
            // Eliminar opciones marcadas para eliminar
            if (!empty($validated['opciones_eliminar'])) {
                OpcionRespuesta::whereIn('id', $validated['opciones_eliminar'])->delete();
            }
            
            // Actualizar o crear preguntas y opciones
            foreach ($validated['preguntas'] as $preguntaData) {
                if (isset($preguntaData['id'])) {
                    // Actualizar pregunta existente
                    $pregunta = $evaluacion->preguntas()->find($preguntaData['id']);
                    $pregunta->update([
                        'enunciado' => $preguntaData['enunciado'],
                        'tipo_pregunta' => $preguntaData['tipo_pregunta'],
                        'puntaje' => $preguntaData['puntaje'],
                        'orden' => $preguntaData['orden'],
                        'respuesta_correcta' => $preguntaData['respuesta_correcta'] ?? null,
                    ]);
                } else {
                    // Crear nueva pregunta
                    $pregunta = $evaluacion->preguntas()->create([
                        'enunciado' => $preguntaData['enunciado'],
                        'tipo_pregunta' => $preguntaData['tipo_pregunta'],
                        'puntaje' => $preguntaData['puntaje'],
                        'orden' => $preguntaData['orden'],
                        'respuesta_correcta' => $preguntaData['respuesta_correcta'] ?? null,
                    ]);
                }
                
                // Actualizar o crear opciones si es necesario
                if (in_array($preguntaData['tipo_pregunta'], ['opcion_unica', 'opcion_multiple', 'verdadero_falso'])) {
                    foreach ($preguntaData['opciones'] as $opcionData) {
                        if (isset($opcionData['id'])) {
                            // Actualizar opción existente
                            $pregunta->opcionesRespuesta()->where('id', $opcionData['id'])->update([
                                'texto' => $opcionData['texto'],
                                'es_correcta' => $opcionData['es_correcta'],
                                'orden' => $opcionData['orden'],
                            ]);
                        } else {
                            // Crear nueva opción
                            $pregunta->opcionesRespuesta()->create([
                                'texto' => $opcionData['texto'],
                                'es_correcta' => $opcionData['es_correcta'],
                                'orden' => $opcionData['orden'],
                            ]);
                        }
                    }
                }
            }
            
            DB::commit();
            
            return redirect()
                ->route('docente.ovas.evaluaciones.show', [$ova, $evaluacion])
                ->with('success', 'Evaluación actualizada exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al actualizar la evaluación: ' . $e->getMessage());
        }
    }
    
    public function destroy(Ova $ova, EvaluacionFinal $evaluacion)
    {
        $this->authorize('update', $ova);
        
        if ($evaluacion->intentos()->exists()) {
            return back()->with('error', 'No se puede eliminar la evaluación porque tiene intentos registrados.');
        }
        
        try {
            DB::beginTransaction();
            
            // Eliminar opciones de respuesta
            $evaluacion->preguntas()->each(function($pregunta) {
                $pregunta->opcionesRespuesta()->delete();
            });
            
            // Eliminar preguntas
            $evaluacion->preguntas()->delete();
            
            // Eliminar la evaluación
            $evaluacion->delete();
            
            DB::commit();
            
            return redirect()
                ->route('docente.ovas.evaluaciones.index', $ova)
                ->with('success', 'Evaluación eliminada exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar la evaluación: ' . $e->getMessage());
        }
    }
} 