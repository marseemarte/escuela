<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Cupof;
use App\Models\Personas\Persona;

class InformePeriodo extends Model
{
    use HasFactory;

    protected $table = 'informe_periodo';

    public $timestamps = false;

    protected $fillable = [
        'id_asignacionesalumnos',
        'cupof',
        'dni_personal',
        'fecha',
        'nota',
        'periodo'
    ];

    protected $casts = [
        'fecha' => 'date',
        'nota' => 'decimal:2',
        'periodo' => 'integer'
    ];

    // Relación con CUPOF
    public function cupofRelation(): BelongsTo
    {
        return $this->belongsTo(Cupof::class, 'cupof', 'cupof');
    }

    // Relación con profesor (persona)
    public function profesor(): BelongsTo
    {
        return $this->belongsTo(Persona::class, 'dni_personal', 'dni');
    }

    // Scopes para facilitar consultas
    public function scopePorPeriodo($query, $periodo)
    {
        return $query->where('periodo', $periodo);
    }

    public function scopePorCupof($query, $cupof)
    {
        return $query->where('cupof', $cupof);
    }

    public function scopePorProfesor($query, $dni)
    {
        return $query->where('dni_personal', $dni);
    }
}
