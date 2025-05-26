<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ova;
use App\Models\ForumThread;
use App\Models\ForumReply;
use App\Models\ForumThreadReaction;
use App\Models\ForumThreadView;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ForumThreadController extends Controller
{
    public function index(Ova $ova)
    {
        $this->authorize('view', $ova);
        
        $threads = $ova->forumThreads()
            ->with(['user', 'replies.user'])
            ->withCount(['replies', 'reactions', 'views'])
            ->latest('ultima_respuesta_at')
            ->paginate(10);
            
        return view('estudiante.foro.index', compact('ova', 'threads'));
    }
    
    public function create(Ova $ova)
    {
        $this->authorize('view', $ova);
        
        return view('estudiante.foro.create', compact('ova'));
    }
    
    public function store(Request $request, Ova $ova)
    {
        $this->authorize('view', $ova);
        
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
        ]);
        
        $thread = $ova->forumThreads()->create([
            'titulo' => $validated['titulo'],
            'contenido' => $validated['contenido'],
            'estado' => true,
            'numero_vistas' => 0,
            'numero_respuestas' => 0,
            'ultima_respuesta_at' => now(),
            'user_id' => Auth::id(),
        ]);
        
        // Registrar la vista del creador
        $thread->views()->create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'user_id' => Auth::id(),
        ]);
        
        return redirect()
            ->route('estudiante.ovas.foro.show', [$ova, $thread])
            ->with('success', 'Hilo creado exitosamente.');
    }
    
    public function show(Ova $ova, ForumThread $thread)
    {
        $this->authorize('view', $ova);
        
        // Verificar que el hilo pertenece al OVA
        if ($thread->ova_id !== $ova->id) {
            abort(404);
        }
        
        // Cargar relaciones
        $thread->load([
            'user',
            'replies.user',
            'reactions.user',
            'views' => function($query) {
                $query->latest()->take(5);
            },
        ]);
        
        // Registrar vista si el usuario no ha visto el hilo
        if (!Auth::check() || !$thread->views()->where('user_id', Auth::id())->exists()) {
            $thread->views()->create([
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'user_id' => Auth::id(),
            ]);
            
            $thread->increment('numero_vistas');
        }
        
        return view('estudiante.foro.show', compact('ova', 'thread'));
    }
    
    public function edit(Ova $ova, ForumThread $thread)
    {
        $this->authorize('update', $thread);
        
        return view('estudiante.foro.edit', compact('ova', 'thread'));
    }
    
    public function update(Request $request, Ova $ova, ForumThread $thread)
    {
        $this->authorize('update', $thread);
        
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'estado' => 'boolean',
        ]);
        
        $thread->update($validated);
        
        return redirect()
            ->route('estudiante.ovas.foro.show', [$ova, $thread])
            ->with('success', 'Hilo actualizado exitosamente.');
    }
    
    public function destroy(Ova $ova, ForumThread $thread)
    {
        $this->authorize('delete', $thread);
        
        // Eliminar reacciones
        $thread->reactions()->delete();
        
        // Eliminar vistas
        $thread->views()->delete();
        
        // Eliminar respuestas
        $thread->replies()->delete();
        
        // Eliminar el hilo
        $thread->delete();
        
        return redirect()
            ->route('estudiante.ovas.foro.index', $ova)
            ->with('success', 'Hilo eliminado exitosamente.');
    }
    
    public function react(Request $request, Ova $ova, ForumThread $thread)
    {
        $this->authorize('view', $ova);
        
        $validated = $request->validate([
            'tipo_reaccion' => ['required', Rule::in(['like', 'dislike', 'helpful', 'report'])],
        ]);
        
        // Verificar si el usuario ya reaccionó
        $existingReaction = $thread->reactions()
            ->where('user_id', Auth::id())
            ->first();
            
        if ($existingReaction) {
            if ($existingReaction->tipo_reaccion === $validated['tipo_reaccion']) {
                // Si es la misma reacción, eliminarla
                $existingReaction->delete();
            } else {
                // Si es diferente, actualizarla
                $existingReaction->update([
                    'tipo_reaccion' => $validated['tipo_reaccion'],
                ]);
            }
        } else {
            // Crear nueva reacción
            $thread->reactions()->create([
                'tipo_reaccion' => $validated['tipo_reaccion'],
                'user_id' => Auth::id(),
            ]);
        }
        
        return back()->with('success', 'Reacción registrada exitosamente.');
    }
} 