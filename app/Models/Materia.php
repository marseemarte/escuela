<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    public function orientacion()
    {
        return $this->belongsTo(\App\Models\Cursos\Orientacion::class, 'orientacion_id');
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
