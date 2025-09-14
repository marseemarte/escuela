<?php

namespace App\Models;

use App\Models\Cursos\Curso;
use App\Models\Cursos\Grupo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cupof extends Model
{
    protected $table = 'cupof';

    protected $primaryKey = 'cupof';

    protected $fillable = [
        'cupof',
        'turno',
        'hsmodcar',
        'id_materias',
        'id_cursos',
        'id_grupos',
        'estado',
        'funcion',
        'cargo'
    ];
    protected $casts = [
        'cupof' => 'integer',
        'hsmodcar' => 'integer',
        'id_materias' => 'integer',
        'id_cursos' => 'integer',
        'id_grupos' => 'integer',
    ];

    // Relaciones

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'id_materias');
    }

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'id_cursos');
    }

    public function grupo(): BelongsTo
    {
        return $this->belongsTo(Grupo::class, 'id_grupos');
    }

    public function asistencias(): HasMany
    {
        return $this->hasMany(Asistencia::class, 'cupof', 'cupof');
    }

    // Scopes y Accessors

    public function scopePorDescripcion($query, $descripcion)
    {
        return $query->where('descripcion', 'like', "%$descripcion%");
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 'A');
    }
}
