<?php

namespace App\Models\Cursos;

use App\Models\Personas\AsignacionAlumno;
use App\Models\Cursos\Curso;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CursoCicloLectivo extends Model
{
    protected $table = 'cursociclolectivo';

    protected $fillable = [
        'estado',
        'ciclolectivo',
        'id_cursos',
    ];

    protected $casts = [
        'ciclolectivo' => 'integer',
        'id_cursos' => 'integer',
    ];

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'id_cursos');
    }

    public function asignaciones(): HasMany
    {
        return $this->hasMany(AsignacionAlumno::class, 'id_cursosciclolectivo');
    }

    // Scopes y Accessors
    public function scopePorCiclo($query, $ciclo)
    {
        return $query->where('ciclolectivo', $ciclo);
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }
}
