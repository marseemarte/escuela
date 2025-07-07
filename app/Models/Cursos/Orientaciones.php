<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;

class Orientaciones extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }
}
