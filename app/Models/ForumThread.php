<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumThread extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'contenido',
        'estado',
        'numero_vistas',
        'numero_respuestas',
        'ultima_respuesta_at',
        'ova_id',
        'user_id'
    ];

    protected $casts = [
        'estado' => 'boolean',
        'numero_vistas' => 'integer',
        'numero_respuestas' => 'integer',
        'ultima_respuesta_at' => 'datetime'
    ];

    // Relaciones
    public function ova(): BelongsTo
    {
        return $this->belongsTo(Ova::class);
    }

    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function respuestas(): HasMany
    {
        return $this->hasMany(ForumReply::class);
    }

    public function reacciones(): HasMany
    {
        return $this->hasMany(ForumThreadReaction::class);
    }

    public function vistas(): HasMany
    {
        return $this->hasMany(ForumThreadView::class);
    }
}
