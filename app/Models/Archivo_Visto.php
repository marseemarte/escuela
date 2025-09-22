<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArchivoVisto extends Model
{
    protected $table = 'archivos_visto';

    protected $fillable = [
        'id_tarea',
        'id_asignacionesalumnos',
        'visto',
        'tipo',
        'fecha'
    ];

    protected $casts = [
        'fecha' => 'date',
        'visto' => 'integer',
        'id_tarea' => 'integer',
        'id_asignacionesalumnos' => 'integer'
    ];

    // Relaciones
    public function tarea(): BelongsTo
    {
        return $this->belongsTo(Tarea::class, 'id_tarea');
    }

    public function asignacionAlumno(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Personas\AsignacionAlumno::class, 'id_asignacionesalumnos');
    }

    // Scopes
    public function scopeVistos($query)
    {
        return $query->where('visto', 1);
    }

    public function scopeNoVistos($query)
    {
        return $query->where('visto', 0);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}