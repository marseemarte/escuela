<?php
// filepath: app/Models/Personas/TipoUsuario.php

namespace App\Models\Personas;

use App\Models\JefeDepartamentoMateria;
use App\Models\Materia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TipoUsuario extends Model
{
    protected $table = 'tipousuario';

    protected $fillable = [
        'id_persona',
        'id_tipopersona',
        'usuario',
        'password',
        'estado',
    ];

    protected $hidden = [
        'password',
    ];

    // Relaciones existentes
    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    public function tipoPersona(): BelongsTo
    {
        return $this->belongsTo(TipoPersona::class, 'id_tipopersona');
    }

    public function asignaciones(): HasOne
    {
        return $this->hasOne(AsignacionAlumno::class, 'id_tipousuario');
    }

    /**
     * Relación: Materias asignadas como jefe (many-to-many)
     */
    public function materiasComoJefe(): BelongsToMany
    {
        return $this->belongsToMany(
            Materia::class,
            'jefe_departamento_materia',
            'id_jefe',
            'id_materia'
        )
            ->withPivot('fecha_asignacion', 'estado')
            ->withTimestamps()
            ->wherePivot('estado', 'A');
    }

    /**
     * Verificar si es jefe de departamento
     */
    public function esJefeDepartamento(): bool
    {
        return $this->tipoPersona && $this->tipoPersona->tipo === 'Jefe de Departamento';
    }

    /**
     * Obtener materias activas del jefe
     */
    public function getMateriasActivasAttribute()
    {
        if (!$this->esJefeDepartamento()) {
            return collect([]);
        }

        return $this->materiasComoJefe;
    }

    /**
     * Verificar si tiene una materia asignada
     */
    public function tieneMateriaAsignada($idMateria): bool
    {
        return $this->asignacionesJefe()
            ->activas()
            ->where('id_materia', $idMateria)
            ->exists();
    }

    // Scopes existentes
    public function scopePorTipo($query, $tipo)
    {
        return $query->whereHas('tipoPersona', function ($q) use ($tipo) {
            $q->where('tipo', $tipo);
        });
    }

    public function scopePorPersona($query, $idPersona)
    {
        return $query->where('id_persona', $idPersona);
    }
}
