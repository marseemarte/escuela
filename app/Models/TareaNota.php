<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TareaNota extends Model
{
    protected $table = 'tareas_notas';

    protected $fillable = [
        'id_tarea',
        'id_asignacionesalumnos',
        'nota'
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
}
