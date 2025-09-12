<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $fillable = [
        'nombre',
        'abreviatura',
        'estado',
        'resumen',
    ];

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
