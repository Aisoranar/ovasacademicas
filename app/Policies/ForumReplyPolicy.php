<?php

namespace App\Policies;

use App\Models\ForumReply;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumReplyPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }
    
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ForumReply $reply): bool
    {
        // Si el usuario es estudiante y pertenece al programa académico del OVA, puede verlo
        if ($user->rol === 'estudiante' && $user->programa_academico_id === $reply->thread->ova->programa_academico_id) {
            return true;
        }
        
        // Si el usuario es docente del OVA, puede verlo
        if ($user->rol === 'docente' && $user->id === $reply->thread->ova->docente_id) {
            return true;
        }
        
        // Si el usuario es administrador, puede verlo
        if ($user->rol === 'admin') {
            return true;
        }
        
        return false;
    }
    
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Solo los estudiantes pueden crear respuestas
        return $user->rol === 'estudiante';
    }
    
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ForumReply $reply): bool
    {
        // Si el usuario es el creador de la respuesta, puede actualizarla
        if ($user->id === $reply->user_id) {
            return true;
        }
        
        // Si el usuario es docente del OVA, puede actualizarla
        if ($user->rol === 'docente' && $user->id === $reply->thread->ova->docente_id) {
            return true;
        }
        
        // Si el usuario es administrador, puede actualizarla
        if ($user->rol === 'admin') {
            return true;
        }
        
        return false;
    }
    
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ForumReply $reply): bool
    {
        // Si el usuario es el creador de la respuesta, puede eliminarla
        if ($user->id === $reply->user_id) {
            return true;
        }
        
        // Si el usuario es docente del OVA, puede eliminarla
        if ($user->rol === 'docente' && $user->id === $reply->thread->ova->docente_id) {
            return true;
        }
        
        // Si el usuario es administrador, puede eliminarla
        if ($user->rol === 'admin') {
            return true;
        }
        
        return false;
    }
    
    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ForumReply $reply): bool
    {
        // Si el usuario es docente del OVA, puede restaurarla
        if ($user->rol === 'docente' && $user->id === $reply->thread->ova->docente_id) {
            return true;
        }
        
        // Si el usuario es administrador, puede restaurarla
        if ($user->rol === 'admin') {
            return true;
        }
        
        return false;
    }
    
    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ForumReply $reply): bool
    {
        // Solo el administrador puede eliminar permanentemente
        return $user->rol === 'admin';
    }
} 