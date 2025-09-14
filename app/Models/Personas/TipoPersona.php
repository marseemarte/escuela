<?php

namespace App\Models\Personas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoPersona extends Model
{
    protected $table = 'tipopersona';

    protected $fillable = [
        'tipo',
    ];

    //Relaciones
    public function tiposUsuario(): HasMany
    {
        return $this->hasMany(TipoUsuario::class, 'id_tipopersona');
    }

    //Scopes y Accessors

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}
