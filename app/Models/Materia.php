<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $table = 'materias';

    protected $fillable = [
        'nombre',
        'abreviatura',
        'estado',
        'resumen',
        'activo',
    ];

    protected static function booted()
    {
        static::addGlobalScope('activo', function ($query) {
            $query->where('activo', 1);
        });
    }
}
