<?php

namespace App\Models\Personas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoUsuario extends Model
{
    protected $table = 'tipousuario';

    protected $fillable = [
        'id_persona',
        'id_tipopersona',
    ];

    //Relaciones
    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    public function tipoPersona(): BelongsTo
    {
        return $this->belongsTo(TipoPersona::class, 'id_tipopersona');
    }

    public function asignaciones(): HasMany
    {
        return $this->hasMany(AsignacionAlumno::class, 'id_tipousuario');
    }

    //Scopes y Accessors

    public function scopePorTipo($query, $tipo)
    {
        return $query->whereHas('tipoPersona', function ($q) use ($tipo) {
            $q->where('tipo', $tipo);
        });
    }
    public function scopePorPersona($query, $idPersona)
    {
        return $query->where('id_persona', $idPersona);
    }
}
