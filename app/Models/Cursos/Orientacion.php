<?php

namespace App\Models\Cursos;

use App\Models\Materia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orientacion extends Model
{
    protected $table = 'orientaciones';
    protected $fillable = [
        'nombre',
        'titulo',
        'color',
    ];

    // Relaciones
    public function materias(): HasMany
    {
        return $this->hasMany(Materia::class, 'orientacion_id');
    }

    public function cursos(): HasMany
    {
        return $this->hasMany(Curso::class);
    }
}
