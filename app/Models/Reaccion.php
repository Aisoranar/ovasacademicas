<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reaccion extends Model
{
    protected $fillable = ['ova_id', 'user_id', 'tipo'];

    public function ova()
    {
        return $this->belongsTo(Ova::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
