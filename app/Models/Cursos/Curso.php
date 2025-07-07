<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;


class Curso extends Model
{
    protected $fillable = [
        'division',
        'ano',
        'turno',
    ];
}
