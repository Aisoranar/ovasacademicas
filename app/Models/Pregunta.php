<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pregunta extends Model
{
    use HasFactory;

    protected $fillable = [
        'pregunta',
        'tipo_pregunta',
        'puntaje',
        'orden',
        'estado',
        'evaluacion_final_id'
    ];

    protected $casts = [
        'puntaje' => 'integer',
        'orden' => 'integer',
        'estado' => 'boolean'
    ];

    // Relaciones
    public function evaluacionFinal(): BelongsTo
    {
        return $this->belongsTo(EvaluacionFinal::class);
    }

    public function opcionesRespuesta(): HasMany
    {
        return $this->hasMany(OpcionRespuesta::class);
    }

    public function respuestasIntento(): HasMany
    {
        return $this->hasMany(IntentoEvaluacion::class, 'pregunta_id');
    }
}
