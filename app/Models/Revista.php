<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Revista extends Model
{
    protected $table = 'revista';

    protected $fillable = [
        'cupof',
        'id_tipousuario',
        'fd',
        'fh',
        'secuencia',
        'situacion',
        'estado'
    ];

    protected $casts = [
        'fd' => 'date',
        'fh' => 'date',
        'secuencia' => 'integer',
        'situacion' => 'string',
        'estado' => 'string',
    ];

    // Relaciones
    public function tipoUsuario(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Personas\TipoUsuario::class, 'id_tipousuario');
    }

    public function cupof(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Cupof::class, 'cupof', 'cupof');
    }

    public function tareas(): HasMany
    {
        return $this->hasMany(Tarea::class, 'id_revista');
    }

    public function planificaciones(): HasMany
    {
        return $this->hasMany(Planificacion::class, 'id_revista');
    }

    public function planificacionActual(): HasOne
    {
        return $this->hasOne(Planificacion::class, 'id_revista')->latestOfMany();
    }
}
