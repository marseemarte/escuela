<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Cursos\Orientacion;
use App\Models\Cursos\Curso;

class Materia extends Model
{
    protected $fillable = [
        'nombre',
        'abreviatura',
        'estado',
        'resumen',
        'tipo',
        'anio',
        'orientacion_id',
        'curso_id',
    ];

    protected $casts = [
        'anio' => 'integer',
    ];

    // Relaciones
    public function orientacion(): BelongsTo
    {
        return $this->belongsTo(Orientacion::class);
    }

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }

    // Scopes y Accessors
    public function scopePorOrientacion($query, $orientacionId)
    {
        return $query->where('orientacion_id', $orientacionId);
    }

    public function scopePorAnio($query, $anio)
    {
        return $query->where('anio', $anio);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}
