<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EvaluacionFinal extends Model
{
    use HasFactory;

    protected $table = 'evaluaciones_finales';

    protected $fillable = [
        'titulo',
        'descripcion',
        'tiempo_limite',
        'intentos_permitidos',
        'puntaje_minimo',
        'estado',
        'ova_id'
    ];

    protected $casts = [
        'tiempo_limite' => 'integer',
        'intentos_permitidos' => 'integer',
        'puntaje_minimo' => 'integer',
        'estado' => 'boolean'
    ];

    // Relaciones
    public function ova(): BelongsTo
    {
        return $this->belongsTo(Ova::class);
    }

    public function preguntas(): HasMany
    {
        return $this->hasMany(Pregunta::class);
    }

    public function intentos(): HasMany
    {
        return $this->hasMany(IntentoEvaluacion::class);
    }
}
