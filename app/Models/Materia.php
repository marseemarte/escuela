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

    /**
     * Obtiene la orientación a la que pertenece la materia
     */
    public function orientacion(): BelongsTo
    {
        return $this->belongsTo(Orientacion::class);
    }

    /**
     * Obtiene el curso al que pertenece la materia
     */
    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }

    /**
     * Scope para filtrar por orientación
     */
    public function scopePorOrientacion($query, $orientacionId)
    {
        return $query->where('orientacion_id', $orientacionId);
    }

    /**
     * Scope para filtrar por año
     */
    public function scopePorAnio($query, $anio)
    {
        return $query->where('anio', $anio);
    }

    /**
     * Scope para filtrar por tipo
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}
