<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IntentoEvaluacion extends Model
{
    use HasFactory;

    protected $table = 'intentos_evaluacion';

    protected $fillable = [
        'puntaje_obtenido',
        'tiempo_inicio',
        'tiempo_fin',
        'estado',
        'respuestas',
        'evaluacion_final_id',
        'user_id'
    ];

    protected $casts = [
        'puntaje_obtenido' => 'integer',
        'tiempo_inicio' => 'datetime',
        'tiempo_fin' => 'datetime',
        'estado' => 'boolean',
        'respuestas' => 'array'
    ];

    // Relaciones
    public function evaluacionFinal(): BelongsTo
    {
        return $this->belongsTo(EvaluacionFinal::class);
    }

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
