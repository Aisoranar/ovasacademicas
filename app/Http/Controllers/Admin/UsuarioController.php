<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProgramaAcademico;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::with(['programaAcademico'])
            ->latest()
            ->paginate(10);
            
        return view('admin.usuarios.index', compact('usuarios'));
    }
    
    public function create()
    {
        $programas = ProgramaAcademico::where('estado', true)->get();
        return view('admin.usuarios.create', compact('programas'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'identificacion' => 'required|string|max:20|unique:users',
            'rol' => ['required', Rule::in(['admin', 'docente', 'estudiante'])],
            'programa_academico_id' => 'required_if:rol,estudiante|exists:programas_academicos,id',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = User::create([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'email' => $validated['email'],
            'identificacion' => $validated['identificacion'],
            'rol' => $validated['rol'],
            'programa_academico_id' => $validated['programa_academico_id'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);
        
        return redirect()
            ->route('admin.usuarios.show', $user)
            ->with('success', 'Usuario creado exitosamente.');
    }
    
    public function show(User $usuario)
    {
        $usuario->load(['programaAcademico']);
        
        // Cargar estadísticas según el rol
        if ($usuario->rol === 'docente') {
            $usuario->loadCount([
                'ovas',
                'ovas as ovas_publicados' => function($query) {
                    $query->where('estado', 'publicado');
                },
                'ovas as total_actividades' => function($query) {
                    $query->withCount('actividades');
                },
                'ovas as total_evaluaciones' => function($query) {
                    $query->withCount('evaluacionesFinales');
                },
            ]);
        } elseif ($usuario->rol === 'estudiante') {
            $usuario->loadCount([
                'progresoActividades as actividades_completadas' => function($query) {
                    $query->where('completada', true);
                },
                'intentosEvaluacion as evaluaciones_completadas' => function($query) {
                    $query->whereNotNull('puntaje_obtenido');
                },
            ]);
            
            $usuario->promedio_evaluaciones = $usuario->intentosEvaluacion()
                ->whereNotNull('puntaje_obtenido')
                ->avg('puntaje_obtenido') ?? 0;
        }
        
        return view('admin.usuarios.show', compact('usuario'));
    }
    
    public function edit(User $usuario)
    {
        $programas = ProgramaAcademico::where('estado', true)->get();
        return view('admin.usuarios.edit', compact('usuario', 'programas'));
    }
    
    public function update(Request $request, User $usuario)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($usuario->id)],
            'identificacion' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($usuario->id)],
            'rol' => ['required', Rule::in(['admin', 'docente', 'estudiante'])],
            'programa_academico_id' => 'required_if:rol,estudiante|exists:programas_academicos,id',
            'password' => 'nullable|string|min:8|confirmed',
            'estado' => 'boolean',
        ]);
        
        // Actualizar datos básicos
        $usuario->update([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'email' => $validated['email'],
            'identificacion' => $validated['identificacion'],
            'rol' => $validated['rol'],
            'programa_academico_id' => $validated['programa_academico_id'] ?? null,
            'estado' => $validated['estado'],
        ]);
        
        // Actualizar contraseña si se proporcionó
        if (!empty($validated['password'])) {
            $usuario->update([
                'password' => Hash::make($validated['password']),
            ]);
        }
        
        return redirect()
            ->route('admin.usuarios.show', $usuario)
            ->with('success', 'Usuario actualizado exitosamente.');
    }
    
    public function destroy(User $usuario)
    {
        // Verificar si el usuario tiene datos asociados
        if ($usuario->rol === 'docente') {
            if ($usuario->ovas()->exists()) {
                return back()->with('error', 'No se puede eliminar el usuario porque tiene OVAs asociados.');
            }
        } elseif ($usuario->rol === 'estudiante') {
            if ($usuario->progresoActividades()->exists() || $usuario->intentosEvaluacion()->exists()) {
                return back()->with('error', 'No se puede eliminar el usuario porque tiene progreso o evaluaciones asociadas.');
            }
        }
        
        $usuario->delete();
        
        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
} 