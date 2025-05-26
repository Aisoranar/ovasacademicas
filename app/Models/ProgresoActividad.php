<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgresoActividad extends Model
{
    use HasFactory;

    protected $table = 'progreso_actividades';

    protected $fillable = [
        'actividad_id',
        'user_id',
        'completada',
        'fecha_completado'
    ];

    protected $casts = [
        'completada' => 'boolean',
        'fecha_completado' => 'datetime'
    ];

    // Relaciones
    public function actividad(): BelongsTo
    {
        return $this->belongsTo(Actividad::class);
    }

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
