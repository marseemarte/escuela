<?php

namespace App\Models\Cursos;

use App\Models\AsignacionAlumno;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grupo extends Model
{
    protected $table = 'grupos';

    protected $fillable = [
        'nombre',
        'id_cursos',
    ];

    // Relaciones
    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'id_cursos');
    }

    public function asignaciones(): HasMany
    {
        return $this->hasMany(AsignacionAlumno::class, 'id_grupos');
    }
}
