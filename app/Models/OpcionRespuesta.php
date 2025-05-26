<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpcionRespuesta extends Model
{
    use HasFactory;

    protected $fillable = [
        'texto',
        'es_correcta',
        'orden',
        'pregunta_id'
    ];

    protected $casts = [
        'es_correcta' => 'boolean',
        'orden' => 'integer'
    ];

    // Relaciones
    public function pregunta(): BelongsTo
    {
        return $this->belongsTo(Pregunta::class);
    }
}
