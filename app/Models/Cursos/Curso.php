<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';

    protected $fillable = [
        'division',
        'ano',
        'turno',
    ];
}
