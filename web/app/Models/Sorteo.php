<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sorteo extends Model
{
    protected $fillable = [
        'juego_id',
        'fecha',
        'numeros',
        'complementarios',
        'bote',
        'premios',
        'localidades',
    ];

    protected $casts = [
        'fecha' => 'date',
        'numeros' => 'array',
        'complementarios' => 'array',
        'premios' => 'array',
        'localidades' => 'array',
        'bote' => 'decimal:2',
    ];

    public function juego()
    {
        return $this->belongsTo(Juego::class);
    }
}
