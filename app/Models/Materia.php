<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'abreviatura',
        'estado',
        'resumen',
        'orientacion_id',
        'anio',
        'tipo',
    ];
    // Relaciones
    public function cupof(): HasMany
    {
        return $this->hasMany(Cupof::class, 'id_materias');
    }
    public function orientacion(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Cursos\Orientacion::class, 'orientacion_id');
    }
    public function planificaciones(): HasMany
    {
        return $this->hasMany(Planificacion::class, 'id_materia');
    }
    public function planificacionActual(): HasOne
    {
        return $this->hasOne(Planificacion::class, 'id_materia')->latestOfMany();
    }

    // Scopes y Accessors

    public function scopeHabilitadas($query)
    {
        return $query->where('estado', 'H');
    }
    public function scopeDeshabilitadas($query)
    {
        return $query->where('estado', 'D');
    }
}
