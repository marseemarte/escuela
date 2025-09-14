<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Materia extends Model
{
    protected $fillable = [
        'nombre',
        'abreviatura',
        'estado',
        'resumen',
    ];
    // Relaciones
    public function cupof(): HasMany
    {
        return $this->hasMany(Cupof::class, 'id_materias');
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
