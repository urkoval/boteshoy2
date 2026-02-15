<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContenidoJuego extends Model
{
    protected $fillable = [
        'juego_id',
        'tipo_contenido',
        'seo_title',
        'meta_description',
        'h1_principal',
        'contenido_html',
        'contenido_markdown',
        'datos_especificos',
        'og_title',
        'og_description',
        'og_image',
        'activo',
    ];

    protected $casts = [
        'datos_especificos' => 'array',
        'activo' => 'boolean',
    ];

    public function juego(): BelongsTo
    {
        return $this->belongsTo(Juego::class);
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopePorTipo($query, string $tipo)
    {
        return $query->where('tipo_contenido', $tipo);
    }

    public function getTipoContenidoLabelAttribute(): string
    {
        return match($this->tipo_contenido) {
            'apuestas_multiples' => 'Apuestas Múltiples',
            'apuestas_reducidas' => 'Apuestas Reducidas',
            'combinacion_ganadora' => 'Combinación Ganadora',
            default => ucfirst(str_replace('_', ' ', $this->tipo_contenido)),
        };
    }
}
