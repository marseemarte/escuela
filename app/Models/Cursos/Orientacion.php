<?php

namespace App\Models\Cursos;

use App\Models\Materia;
use Illuminate\Database\Eloquent\Model;

class Orientacion extends Model
{
    protected $table = 'orientaciones';
    protected $fillable = [
        'nombre',
        'titulo',
        'color',
    ];

    // Relaciones
    public function materias()
    {
        return $this->hasMany(Materia::class, 'orientacion_id');
    }

    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }
}
