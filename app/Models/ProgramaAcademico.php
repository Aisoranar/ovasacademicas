<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramaAcademico extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'programas_academicos';

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'estado'
    ];

    protected $casts = [
        'estado' => 'boolean'
    ];

    // Relaciones
    public function ovas(): HasMany
    {
        return $this->hasMany(Ova::class, 'programa_id');
    }

    public function temas(): HasMany
    {
        return $this->hasMany(Tema::class);
    }

    public function estudiantes(): HasMany
    {
        return $this->hasMany(User::class)->where('rol', 'estudiante');
    }

    public function docentes(): HasMany
    {
        return $this->hasMany(User::class)->where('rol', 'docente');
    }

    public function etiquetas()
    {
        return $this->hasMany(Etiqueta::class, 'programa_academico_id');
    }

    public function forumThreads()
    {
        return $this->hasMany(ForumThread::class, 'programa_academico_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'programa_id');
    }
}
