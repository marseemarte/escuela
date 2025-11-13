<?php
// filepath: app/Models/Personas/TipoPersona.php

namespace App\Models\Personas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoPersona extends Model
{
    protected $table = 'tipopersona';

    protected $fillable = [
        'tipo',
        'descripcion',
    ];

    /**
     * Relación: Tipos de usuario asociados
     */
    public function tiposUsuario(): HasMany
    {
        return $this->hasMany(TipoUsuario::class, 'id_tipopersona');
    }

    /**
     * Relación: Asignaciones como jefe de departamento
     */
    public function asignacionesJefe(): HasMany
    {
        return $this->hasMany(JefeDepartamentoMateria::class, 'id_jefe');
    }

    /**
     * Scope: Por tipo específico
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Verificar si es tipo jefe de departamento
     */
    public function esJefeDepartamento(): bool
    {
        return $this->tipo === 'Jefe de Departamento';
    }
}
