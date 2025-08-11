<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;

class Orientacion extends Model
{
    protected $table = 'orientaciones';
    protected $fillable = [
        'nombre',
        'titulo',
    ];

    /**
     * Obtiene las materias de esta orientación
     */
    public function materias()
    {
        return $this->hasMany(Materia::class, 'orientacion_id');
    }

    /**
     * Obtiene los cursos de esta orientación
     */
    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }
}
