<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    protected $fillable = ['slug', 'nombre', 'dias_sorteo'];

    public function sorteos()
    {
        return $this->hasMany(Sorteo::class);
    }

    public function ultimoSorteo()
    {
        return $this->hasOne(Sorteo::class)->latestOfMany('fecha');
    }
}
