<?php

namespace App\Models;

use App\Models\Personas\TipoUsuario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'departamento';

    protected $fillable = [
        'id_tipousuario',
        'nombre',
        'descripcion',
        'estado'
    ];

    // Relación con TipoUsuario (Profesor jefe)
    public function tipoUsuario()
    {
        return $this->belongsTo(TipoUsuario::class, 'id_tipousuario');
    }

    // Relación muchos a muchos con Materia
    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'departamento_materia', 'id_departamento', 'id_materia')
            ->withTimestamps();
    }
}
