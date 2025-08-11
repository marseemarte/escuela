<?php

namespace App\Models\Cursos;

use App\Models\Materia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curso extends Model
{
    protected $table = 'cursos';
    
    protected $fillable = [
        'division',
        'ano',
        'turno',
    ];

    protected $casts = [
        'ano' => 'integer',
    ];

    /**
     * Obtiene las materias de este curso
     */
    public function materias(): HasMany
    {
        return $this->hasMany(Materia::class);
    }

    /**
     * Scope para filtrar por año
     */
    public function scopePorAnio($query, $ano)
    {
        return $query->where('ano', $ano);
    }

    /**
     * Scope para filtrar por turno
     */
    public function scopePorTurno($query, $turno)
    {
        return $query->where('turno', $turno);
    }

    /**
     * Scope para filtrar por división
     */
    public function scopePorDivision($query, $division)
    {
        return $query->where('division', $division);
    }
}
