<?php

namespace App\Models;

use App\Models\Personas\TipoUsuario;
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
        return $this->belongsTo(TipoUsuario::class, 'id_tipousuario', 'id');
    }

    public function cupof(): BelongsTo
    {
        return $this->belongsTo(Cupof::class, 'cupof', 'cupof');
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

    public function proyectos(): HasMany
    {
        return $this->hasMany(Proyecto::class, 'id_revista');
    }

    // Scopes y Accessors

    public function proyectosRecientes($limit = 5)
    {
        return $this->proyectos()->masRecientes()->limit($limit)->get();
    }

    public function totalProyectos()
    {
        return $this->proyectos()->count();
    }
}
