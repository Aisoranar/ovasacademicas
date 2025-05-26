<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ova extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'objetivos_aprendizaje',
        'duracion_total',
        'nivel_dificultad',
        'version',
        'fecha_publicacion',
        'estado',
        'imagen_portada',
        'numero_visualizaciones',
        'nivel_interactividad',
        'docente_id',
        'programa_id',
        'tema_id'
    ];

    protected $casts = [
        'fecha_publicacion' => 'datetime',
        'numero_visualizaciones' => 'integer',
        'nivel_interactividad' => 'integer',
        'duracion_total' => 'integer'
    ];

    // Relaciones
    public function docente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'docente_id');
    }

    public function programa(): BelongsTo
    {
        return $this->belongsTo(ProgramaAcademico::class, 'programa_id');
    }

    public function tema(): BelongsTo
    {
        return $this->belongsTo(Tema::class);
    }

    public function actividades(): HasMany
    {
        return $this->hasMany(Actividad::class);
    }

    public function evaluacionesFinales(): HasMany
    {
        return $this->hasMany(EvaluacionFinal::class);
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class);
    }

    public function reacciones(): HasMany
    {
        return $this->hasMany(Reaccion::class);
    }

    public function forumThreads(): HasMany
    {
        return $this->hasMany(ForumThread::class);
    }

    public function etiquetas(): BelongsToMany
    {
        return $this->belongsToMany(Etiqueta::class, 'ova_etiqueta')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopePublicados($query)
    {
        return $query->where('estado', 'publicado');
    }

    public function scopePorTema($query, $temaId)
    {
        return $query->where('tema_id', $temaId);
    }

    public function scopePorDocente($query, $docenteId)
    {
        return $query->where('docente_id', $docenteId);
    }
}
