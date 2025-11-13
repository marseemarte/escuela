<?php
// filepath: app/Models/Materia.php

namespace App\Models;

use App\Models\Personas\TipoUsuario;
use App\Models\JefeDepartamentoMateria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    // Relaciones existentes
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

    /**
     * Relación: Asignaciones de jefes de departamento
     */
    public function asignacionesJefes(): HasMany
    {
        return $this->hasMany(JefeDepartamentoMateria::class, 'id_materia');
    }

    /**
     * Relación: Jefes de departamento asignados (many-to-many)
     */
    public function jefes(): BelongsToMany
    {
        return $this->belongsToMany(
            TipoUsuario::class,
            'jefe_departamento_materia',
            'id_materia',
            'id_jefe'
        )
            ->withPivot('fecha_asignacion', 'estado')
            ->withTimestamps()
            ->wherePivot('estado', 'A');
    }

    /**
     * Obtener jefes activos
     */
    public function getJefesActivosAttribute()
    {
        return $this->asignacionesJefes()
            ->activas()
            ->with('jefe.persona')
            ->get();
    }

    /**
     * Verificar si tiene jefes asignados
     */
    public function tieneJefesAsignados(): bool
    {
        return $this->asignacionesJefes()->activas()->exists();
    }

    /**
     * Obtener el primer jefe activo
     */
    public function getPrimerJefeAttribute()
    {
        return $this->asignacionesJefes()
            ->activas()
            ->with('jefe.persona')
            ->first();
    }

    // Scopes existentes
    public function scopeHabilitadas($query)
    {
        return $query->where('estado', 'H');
    }

    public function scopeDeshabilitadas($query)
    {
        return $query->where('estado', 'D');
    }
}
