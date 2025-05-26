<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecursoActividad extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'titulo',
        'tipo_recurso',
        'url_recurso',
        'descripcion',
        'orden',
        'estado',
        'actividad_id'
    ];

    protected $casts = [
        'orden' => 'integer',
        'estado' => 'boolean'
    ];

    // Relaciones
    public function actividad(): BelongsTo
    {
        return $this->belongsTo(Actividad::class);
    }
} 