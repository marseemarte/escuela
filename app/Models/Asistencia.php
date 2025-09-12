<?php

namespace App\Models;

use App\Models\Personas\AsignacionAlumno;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asistencia extends Model
{
    // Constantes para estados de asistencia
    const PRESENTE = 'P';
    const AUSENTE = 'A';
    const TARDANZA = 'T';
    const JUSTIFICADO = 'J';

    // Constantes para justificación
    const JUSTIFICADO_SI = '1';
    const JUSTIFICADO_NO = '0';

    // Constantes para turnos
    const TURNO_MANANA = 'M';
    const TURNO_TARDE = 'T';
    const TURNO_NOCHE = 'N';

    protected $table = 'inasistenciasalumnos';

    protected $fillable = [
        'id_asignacionesalumnos',
        'fecha',
        'turno',
        'estado',
        'justificado',
        'dni_personal',
    ];

    protected $attributes = [
        'estado' => 'A', // Ausente por defecto
        'justificado' => '0', // No justificado por defecto
    ];

    protected $casts = [
        'fecha' => 'date',
        'dni_personal' => 'integer',
        'id_asignacionesalumnos' => 'integer',
    ];

    public function asignacionAlumno(): BelongsTo
    {
        return $this->belongsTo(AsignacionAlumno::class, 'id_asignacionesalumnos');
    }

    public function scopePorFecha($query, $fecha)
    {
        return $query->where('fecha', $fecha);
    }

    public function scopePorTurno($query, $turno)
    {
        return $query->where('turno', $turno);
    }

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopeJustificadas($query)
    {
        return $query->where('justificado', '1');
    }

    public function scopeNoJustificadas($query)
    {
        return $query->where('justificado', '0');
    }

    public function getEsJustificadaAttribute()
    {
        return $this->justificado === '1';
    }

    public function getEstadoDescriptivoAttribute()
    {
        return match ($this->estado) {
            'P' => 'Presente',
            'A' => 'Ausente',
            'T' => 'Tardanza',
            'J' => 'Justificado',
            default => "No definido"
        };
    }
}
