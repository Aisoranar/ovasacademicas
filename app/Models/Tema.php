<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tema extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'objetivos_aprendizaje',
        'duracion_estimada',
        'nivel_dificultad',
        'orden',
        'estado',
        'programa_academico_id'
    ];

    protected $casts = [
        'duracion_estimada' => 'integer',
        'orden' => 'integer',
        'estado' => 'boolean'
    ];

    // Relaciones
    public function programaAcademico(): BelongsTo
    {
        return $this->belongsTo(ProgramaAcademico::class);
    }

    public function ovas(): HasMany
    {
        return $this->hasMany(Ova::class);
    }

    public function actividades(): HasMany
    {
        return $this->hasMany(Actividad::class);
    }
} 