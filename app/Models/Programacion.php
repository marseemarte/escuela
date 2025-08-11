<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programacion extends Model
{
    use HasFactory;

    protected $table = 'materias';

    protected $fillable = [
        'id',
        'nombre',
        'abreviatura',
        'estado',
        'tipo', // 'materia' o 'taller'
        'horas_semanales',
        'horas_anuales'
    ];

    public function materias()
    {
        return $this->where('tipo', 'materia');
    }

    public function talleres()
    {
        return $this->where('tipo', 'taller');
    }

    public function scopePorAnio($query, $anio)
    {
        return $query->where('anio', $anio);
    }
}
