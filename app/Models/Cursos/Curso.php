<?php

namespace App\Models\Cursos;

use App\Models\Cursos\CursoCicloLectivo;
use App\Models\Cursos\Grupo;
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


    public function ciclosLectivos(): HasMany
    {
        return $this->hasMany(CursoCicloLectivo::class, 'id_cursos');
    }
    public function materias(): HasMany
    {
        return $this->hasMany(Materia::class);
    }

    public function grupos(): HasMany
    {
        return $this->hasMany(Grupo::class, 'id_cursos');
    }

    // Scopes y Accessors

    public function scopePorAno($query, $ano)
    {
        return $query->where('ano', $ano);
    }

    public function scopePorTurno($query, $turno)
    {
        return $query->where('turno', $turno);
    }

    public function getNombreCompletoAttribute()
    {
        return "{$this->ano}° {$this->division} - {$this->turno}";
    }

    public function scopePorDivision($query, $division)
    {
        return $query->where('division', $division);
    }
}
