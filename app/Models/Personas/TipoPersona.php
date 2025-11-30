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
        'estado',
    ];

    /**
     * Relación: Tipos de usuario asociados
     */
    public function tiposUsuario(): HasMany
    {
        return $this->hasMany(TipoUsuario::class, 'id_tipopersona');
    }

    /**
     * Scope: Por tipo específico
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}
