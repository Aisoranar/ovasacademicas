<?php

namespace App\Policies;

use App\Models\Ova;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OvaPolicy
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
    public function view(User $user, Ova $ova): bool
    {
        // Si el OVA está publicado, cualquier usuario puede verlo
        if ($ova->estado === 'publicado') {
            return true;
        }
        
        // Si el usuario es el docente del OVA, puede verlo
        if ($user->id === $ova->docente_id) {
            return true;
        }
        
        // Si el usuario es administrador, puede verlo
        if ($user->rol === 'admin') {
            return true;
        }
        
        // Si el usuario es estudiante y pertenece al programa académico del OVA, puede verlo
        if ($user->rol === 'estudiante' && $user->programa_academico_id === $ova->programa_academico_id) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->rol === 'docente';
    }
    
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ova $ova): bool
    {
        // Si el usuario es el docente del OVA, puede actualizarlo
        if ($user->id === $ova->docente_id) {
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
    public function delete(User $user, Ova $ova): bool
    {
        // Si el usuario es el docente del OVA, puede eliminarlo
        if ($user->id === $ova->docente_id) {
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
    public function restore(User $user, Ova $ova): bool
    {
        // Si el usuario es el docente del OVA, puede restaurarlo
        if ($user->id === $ova->docente_id) {
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
    public function forceDelete(User $user, Ova $ova): bool
    {
        // Solo el administrador puede eliminar permanentemente
        return $user->rol === 'admin';
    }
} 