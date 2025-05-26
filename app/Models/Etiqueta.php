<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Etiqueta extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'color',
        'estado'
    ];

    protected $casts = [
        'estado' => 'boolean'
    ];

    // Relaciones
    public function ovas(): BelongsToMany
    {
        return $this->belongsToMany(Ova::class, 'ova_etiqueta')
                    ->withTimestamps();
    }
} 