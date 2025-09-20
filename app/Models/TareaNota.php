<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TareaNota extends Model
{
    protected $table = 'tareas_notas';
    
    // Usar timestamps ya que tienes created_at y updated_at
    public $timestamps = true;

    protected $fillable = [
        'id_tarea',
        'id_asignacionesalumnos',
        'nota',
        'devolucion'
    ];

    protected $casts = [
        'nota' => 'string', // varchar(4) según tu tabla
        'devolucion' => 'string', // varchar(200) según tu tabla
        'id_tarea' => 'integer',
        'id_asignacionesalumnos' => 'integer',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
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