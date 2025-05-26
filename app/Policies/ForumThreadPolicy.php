<?php

namespace App\Policies;

use App\Models\ForumThread;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumThreadPolicy
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
    public function view(User $user, ForumThread $thread): bool
    {
        // Si el usuario es estudiante y pertenece al programa académico del OVA, puede verlo
        if ($user->rol === 'estudiante' && $user->programa_academico_id === $thread->ova->programa_academico_id) {
            return true;
        }
        
        // Si el usuario es docente del OVA, puede verlo
        if ($user->rol === 'docente' && $user->id === $thread->ova->docente_id) {
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
        // Solo los estudiantes pueden crear hilos
        return $user->rol === 'estudiante';
    }
    
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ForumThread $thread): bool
    {
        // Si el usuario es el creador del hilo, puede actualizarlo
        if ($user->id === $thread->user_id) {
            return true;
        }
        
        // Si el usuario es docente del OVA, puede actualizarlo
        if ($user->rol === 'docente' && $user->id === $thread->ova->docente_id) {
            return true;
        }
        
        // Si el usuario es administrador, puede actualizarlo
        if ($user->rol === 'admin') {
            return true;
        }
        
        return false;
    }
    
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ForumThread $thread): bool
    {
        // Si el usuario es el creador del hilo, puede eliminarlo
        if ($user->id === $thread->user_id) {
            return true;
        }
        
        // Si el usuario es docente del OVA, puede eliminarlo
        if ($user->rol === 'docente' && $user->id === $thread->ova->docente_id) {
            return true;
        }
        
        // Si el usuario es administrador, puede eliminarlo
        if ($user->rol === 'admin') {
            return true;
        }
        
        return false;
    }
    
    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ForumThread $thread): bool
    {
        // Si el usuario es docente del OVA, puede restaurarlo
        if ($user->rol === 'docente' && $user->id === $thread->ova->docente_id) {
            return true;
        }
        
        // Si el usuario es administrador, puede restaurarlo
        if ($user->rol === 'admin') {
            return true;
        }
        
        return false;
    }
    
    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ForumThread $thread): bool
    {
        // Solo el administrador puede eliminar permanentemente
        return $user->rol === 'admin';
    }
} 