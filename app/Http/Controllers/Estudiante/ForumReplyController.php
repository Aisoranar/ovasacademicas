<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ova;
use App\Models\ForumThread;
use App\Models\ForumReply;
use Illuminate\Support\Facades\Auth;

class ForumReplyController extends Controller
{
    public function store(Request $request, Ova $ova, ForumThread $thread)
    {
        $this->authorize('view', $ova);
        
        // Verificar que el hilo pertenece al OVA
        if ($thread->ova_id !== $ova->id) {
            abort(404);
        }
        
        $validated = $request->validate([
            'contenido' => 'required|string',
        ]);
        
        $reply = $thread->replies()->create([
            'contenido' => $validated['contenido'],
            'estado' => true,
            'user_id' => Auth::id(),
        ]);
        
        // Actualizar contadores del hilo
        $thread->update([
            'numero_respuestas' => $thread->replies()->count(),
            'ultima_respuesta_at' => now(),
        ]);
        
        return redirect()
            ->route('estudiante.ovas.foro.show', [$ova, $thread])
            ->with('success', 'Respuesta publicada exitosamente.');
    }
    
    public function edit(Ova $ova, ForumThread $thread, ForumReply $reply)
    {
        $this->authorize('update', $reply);
        
        // Verificar que la respuesta pertenece al hilo
        if ($reply->forum_thread_id !== $thread->id) {
            abort(404);
        }
        
        return view('estudiante.foro.edit-reply', compact('ova', 'thread', 'reply'));
    }
    
    public function update(Request $request, Ova $ova, ForumThread $thread, ForumReply $reply)
    {
        $this->authorize('update', $reply);
        
        // Verificar que la respuesta pertenece al hilo
        if ($reply->forum_thread_id !== $thread->id) {
            abort(404);
        }
        
        $validated = $request->validate([
            'contenido' => 'required|string',
            'estado' => 'boolean',
        ]);
        
        $reply->update($validated);
        
        return redirect()
            ->route('estudiante.ovas.foro.show', [$ova, $thread])
            ->with('success', 'Respuesta actualizada exitosamente.');
    }
    
    public function destroy(Ova $ova, ForumThread $thread, ForumReply $reply)
    {
        $this->authorize('delete', $reply);
        
        // Verificar que la respuesta pertenece al hilo
        if ($reply->forum_thread_id !== $thread->id) {
            abort(404);
        }
        
        $reply->delete();
        
        // Actualizar contadores del hilo
        $thread->update([
            'numero_respuestas' => $thread->replies()->count(),
            'ultima_respuesta_at' => $thread->replies()->latest()->first()?->created_at ?? $thread->created_at,
        ]);
        
        return redirect()
            ->route('estudiante.ovas.foro.show', [$ova, $thread])
            ->with('success', 'Respuesta eliminada exitosamente.');
    }
} 