<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\HasEnumValues;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasEnumValues;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre_completo',
        'identificacion',
        'email',
        'password',
        'rol',
        'programa_id',
        'semestre_actual',
        'departamento_academico',
        'tipo_registro'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'fecha_publicacion' => 'datetime'
    ];

    // Relaciones
    public function ovas()
    {
        return $this->hasMany(Ova::class, 'docente_id');
    }

    public function intentosEvaluacion()
    {
        return $this->hasMany(IntentoEvaluacion::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function reacciones()
    {
        return $this->hasMany(Reaccion::class);
    }

    public function forumThreads()
    {
        return $this->hasMany(ForumThread::class);
    }

    public function forumReplies()
    {
        return $this->hasMany(ForumReply::class);
    }

    /**
     * Check if the user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->rol === 'admin';
    }

    /**
     * Check if the user is a teacher
     */
    public function isDocente(): bool
    {
        return $this->rol === 'docente';
    }

    /**
     * Check if the user is a student
     */
    public function isEstudiante(): bool
    {
        return $this->rol === 'estudiante';
    }

    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'docente_id');
    }

    public function progresoActividades()
    {
        return $this->hasMany(ProgresoActividad::class);
    }

    public function forumThreadReactions()
    {
        return $this->hasMany(ForumThreadReaction::class);
    }

    public function forumThreadViews()
    {
        return $this->hasMany(ForumThreadView::class);
    }

    public function programaAcademico()
    {
        return $this->belongsTo(ProgramaAcademico::class, 'programa_id');
    }
}
