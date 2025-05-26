<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actividad extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'actividades';

    protected $fillable = [
        'titulo',
        'descripcion',
        'tipo_actividad',
        'contenido',
        'duracion_estimada',
        'orden',
        'estado',
        'ova_id',
        'tema_id'
    ];

    protected $casts = [
        'duracion_estimada' => 'integer',
        'orden' => 'integer',
        'estado' => 'boolean',
        'contenido' => 'array'
    ];

    // Relaciones
    public function ova(): BelongsTo
    {
        return $this->belongsTo(Ova::class);
    }

    public function tema(): BelongsTo
    {
        return $this->belongsTo(Tema::class);
    }

    public function recursos(): HasMany
    {
        return $this->hasMany(RecursoActividad::class)->orderBy('orden');
    }

    public function progresos(): HasMany
    {
        return $this->hasMany(ProgresoActividad::class);
    }
} 