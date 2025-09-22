<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Taller extends Model
{
    protected $fillable = [
        'nombre',
        'abreviatura',
        'estado',
        'resumen',
        'orientacion_id',
        'anio',
    ];

    // Relaciones
    public function orientacion(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Cursos\Orientacion::class, 'orientacion_id');
    }

    // Scopes y Accessors
    public function scopeHabilitados($query)
    {
        return $query->where('estado', 'H');
    }

    public function scopeDeshabilitados($query)
    {
        return $query->where('estado', 'D');
    }
}
