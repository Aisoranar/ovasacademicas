<?php

namespace App\Policies;

use App\Models\EvaluacionFinal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EvaluacionFinalPolicy
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
    public function view(User $user, EvaluacionFinal $evaluacion): bool
    {
        // Si el usuario es estudiante y pertenece al programa académico del OVA, puede verlo
        if ($user->rol === 'estudiante' && $user->programa_academico_id === $evaluacion->ova->programa_academico_id) {
            return true;
        }
        
        // Si el usuario es docente del OVA, puede verlo
        if ($user->rol === 'docente' && $user->id === $evaluacion->ova->docente_id) {
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
        // Solo los docentes pueden crear evaluaciones
        return $user->rol === 'docente';
    }
    
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, EvaluacionFinal $evaluacion): bool
    {
        // Si el usuario es docente del OVA, puede actualizarlo
        if ($user->rol === 'docente' && $user->id === $evaluacion->ova->docente_id) {
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
    public function delete(User $user, EvaluacionFinal $evaluacion): bool
    {
        // Si el usuario es docente del OVA, puede eliminarlo
        if ($user->rol === 'docente' && $user->id === $evaluacion->ova->docente_id) {
            // Verificar si hay intentos registrados
            if ($evaluacion->intentos()->exists()) {
                return false;
            }
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
    public function restore(User $user, EvaluacionFinal $evaluacion): bool
    {
        // Si el usuario es docente del OVA, puede restaurarlo
        if ($user->rol === 'docente' && $user->id === $evaluacion->ova->docente_id) {
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
    public function forceDelete(User $user, EvaluacionFinal $evaluacion): bool
    {
        // Solo el administrador puede eliminar permanentemente
        return $user->rol === 'admin';
    }
    
    /**
     * Determine whether the user can take the evaluation.
     */
    public function take(User $user, EvaluacionFinal $evaluacion): bool
    {
        // Solo los estudiantes pueden tomar la evaluación
        if ($user->rol !== 'estudiante') {
            return false;
        }
        
        // El estudiante debe pertenecer al programa académico del OVA
        if ($user->programa_academico_id !== $evaluacion->ova->programa_academico_id) {
            return false;
        }
        
        // Verificar si el estudiante ha completado todas las actividades del OVA
        $actividadesCompletadas = $evaluacion->ova->actividades()
            ->whereHas('progresos', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->where('estado_completado', true);
            })
            ->count();
            
        $totalActividades = $evaluacion->ova->actividades()->count();
        
        if ($actividadesCompletadas < $totalActividades) {
            return false;
        }
        
        // Verificar si el estudiante ha excedido el número máximo de intentos
        $intentosRealizados = $evaluacion->intentos()
            ->where('user_id', $user->id)
            ->count();
            
        if ($intentosRealizados >= $evaluacion->numero_intentos) {
            return false;
        }
        
        return true;
    }
} 