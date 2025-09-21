<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TareaAlumno extends Model
{
    protected $table = 'tareas_alumnos';

    protected $fillable = [
        'id_tarea',
        'id_asignacionesalumnos',
        'fecha',
        'nombre_archivo',
        'ruta_archivo', 
        'borrado_fisico'
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'borrado_fisico' => 'integer',
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

    public function tarea_nota(): HasOne
    {
        return $this->hasOne(TareaNota::class, 'id_asignacionesalumnos', 'id_asignacionesalumnos');
    }
}