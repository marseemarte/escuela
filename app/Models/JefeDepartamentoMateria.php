<?php
// filepath: app/Models/JefeDepartamentoMateria.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Personas\TipoUsuario;
use App\Models\Materia;
use App\Models\Proyecto;
use App\Models\Cupof;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JefeDepartamentoMateria extends Model
{
    use HasFactory;

    protected $table = 'jefe_departamento_materia';

    protected $fillable = [
        'id_jefe',
        'id_materia',
        'fecha_asignacion',
        'estado',
    ];

    protected $casts = [
        'fecha_asignacion' => 'date',
    ];

    protected $appends = [
        'nombre_jefe',
        'nombre_materia',
        'dias_desde_asignacion',
    ];

    /**
     * Relación: Una asignación pertenece a un TipoUsuario (jefe)
     */
    public function jefe(): BelongsTo
    {
        return $this->belongsTo(TipoUsuario::class, 'id_jefe');
    }

    /**
     * Relación: Una asignación pertenece a una Materia
     */
    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'id_materia');
    }

    /**
     * Scope: Solo asignaciones activas
     */
    public function scopeActivas($query)
    {
        return $query->where('estado', 'A');
    }

    /**
     * Scope: Solo asignaciones inactivas
     */
    public function scopeInactivas($query)
    {
        return $query->where('estado', 'I');
    }

    /**
     * Scope: Asignaciones de un jefe específico
     */
    public function scopeDeJefe($query, $idJefe)
    {
        return $query->where('id_jefe', $idJefe);
    }

    /**
     * Scope: Asignaciones de una materia específica
     */
    public function scopeDeMateria($query, $idMateria)
    {
        return $query->where('id_materia', $idMateria);
    }

    /**
     * Scope: Asignaciones recientes (últimos 30 días)
     */
    public function scopeRecientes($query)
    {
        return $query->where('fecha_asignacion', '>=', now()->subDays(30));
    }

    /**
     * Scope: Con relaciones cargadas
     */
    public function scopeConRelaciones($query)
    {
        return $query->with(['jefe.persona', 'jefe.tipoPersona', 'materia']);
    }

    /**
     * Obtener todos los CUPOFs relacionados con la materia
     */
    public function cupofs()
    {
        return Cupof::where('id_materias', $this->id_materia)
            ->where('estado', 'A')
            ->with(['materia', 'curso', 'grupo'])
            ->get();
    }

    /**
     * Obtener todos los proyectos de la materia asignada
     */
    public function proyectos()
    {
        return Proyecto::whereHas('revista', function ($query) {
            $query->whereHas('cupof', function ($subQuery) {
                $subQuery->where('id_materias', $this->id_materia)
                    ->where('estado', 'A');
            });
        })->get();
    }

    /**
     * Verificar si la asignación está activa
     */
    public function estaActiva(): bool
    {
        return $this->estado === 'A';
    }

    /**
     * Verificar si el TipoUsuario es realmente Jefe de Departamento
     */
    public function esJefeValido(): bool
    {
        return $this->jefe
            && $this->jefe->tipoPersona
            && $this->jefe->tipoPersona->tipo === 'Jefe de Departamento';
    }

    /**
     * Activar la asignación
     */
    public function activar(): bool
    {
        return $this->update(['estado' => 'A']);
    }

    /**
     * Desactivar la asignación
     */
    public function desactivar(): bool
    {
        return $this->update(['estado' => 'I']);
    }

    /**
     * Accessor: Nombre completo del jefe
     */
    public function getNombreJefeAttribute(): string
    {
        if (!$this->relationLoaded('jefe')) {
            $this->load('jefe.persona');
        }

        if ($this->jefe && $this->jefe->persona) {
            return $this->jefe->persona->apellido . ', ' . $this->jefe->persona->nombre;
        }

        return 'N/A';
    }

    /**
     * Accessor: Nombre de la materia
     */
    public function getNombreMateriaAttribute(): string
    {
        if (!$this->relationLoaded('materia')) {
            $this->load('materia');
        }

        return $this->materia->nombre ?? 'N/A';
    }

    /**
     * Accessor: Días desde la asignación
     */
    public function getDiasDesdeAsignacionAttribute(): int
    {
        if (!$this->fecha_asignacion) {
            return 0;
        }

        return abs(now()->diffInDays($this->fecha_asignacion));
    }

    /**
     * Accessor: Tipo de persona del jefe
     */
    public function getTipoJefeAttribute(): ?string
    {
        if (!$this->relationLoaded('jefe')) {
            $this->load('jefe.tipoPersona');
        }

        return $this->jefe?->tipoPersona?->tipo;
    }

    /**
     * Accessor: Email del jefe
     */
    public function getEmailJefeAttribute(): ?string
    {
        if (!$this->relationLoaded('jefe')) {
            $this->load('jefe.persona');
        }

        return $this->jefe?->persona?->email;
    }

    /**
     * Accessor: Teléfono del jefe
     */
    public function getTelefonoJefeAttribute(): ?string
    {
        if (!$this->relationLoaded('jefe')) {
            $this->load('jefe.persona');
        }

        return $this->jefe?->persona?->telefono;
    }
}
