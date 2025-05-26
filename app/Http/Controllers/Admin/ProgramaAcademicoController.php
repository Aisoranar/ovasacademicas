<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramaAcademico;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProgramaAcademicoController extends Controller
{
    public function index()
    {
        $programas = ProgramaAcademico::withCount(['ovas', 'estudiantes', 'docentes'])
            ->latest()
            ->paginate(10);

        return view('admin.programas.index', compact('programas'));
    }

    public function create()
    {
        return view('admin.programas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:programas_academicos',
            'codigo' => 'required|string|max:50|unique:programas_academicos',
            'descripcion' => 'required|string',
            'estado' => 'boolean'
        ]);

        $programa = ProgramaAcademico::create($validated);

        return redirect()
            ->route('admin.programas.show', $programa)
            ->with('success', 'Programa académico creado exitosamente.');
    }

    public function show(ProgramaAcademico $programa)
    {
        $programa->load(['ovas', 'estudiantes', 'docentes']);
        
        $estadisticas = [
            'total_ovas' => $programa->ovas()->count(),
            'ovas_activos' => $programa->ovas()->where('estado', 'publicado')->count(),
            'total_estudiantes' => $programa->estudiantes()->count(),
            'total_docentes' => $programa->docentes()->count(),
        ];

        return view('admin.programas.show', compact('programa', 'estadisticas'));
    }

    public function edit(ProgramaAcademico $programa)
    {
        return view('admin.programas.edit', compact('programa'));
    }

    public function update(Request $request, ProgramaAcademico $programa)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:programas_academicos,nombre,' . $programa->id,
            'codigo' => 'required|string|max:50|unique:programas_academicos,codigo,' . $programa->id,
            'descripcion' => 'required|string',
            'estado' => 'boolean'
        ]);

        $programa->update($validated);

        return redirect()
            ->route('admin.programas.show', $programa)
            ->with('success', 'Programa académico actualizado exitosamente.');
    }

    public function destroy(ProgramaAcademico $programa)
    {
        // Verificar si hay OVAs asociados
        if ($programa->ovas()->exists()) {
            return back()->with('error', 'No se puede eliminar el programa porque tiene OVAs asociados.');
        }

        // Verificar si hay usuarios asociados
        if ($programa->estudiantes()->exists() || $programa->docentes()->exists()) {
            return back()->with('error', 'No se puede eliminar el programa porque tiene usuarios asociados.');
        }

        $programa->delete();

        return redirect()
            ->route('admin.programas.index')
            ->with('success', 'Programa académico eliminado exitosamente.');
    }
} 