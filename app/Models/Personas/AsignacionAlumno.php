<?php

namespace App\Models\Personas;

use App\Models\Asistencia;
use App\Models\Cursos\CursoCicloLectivo;
use App\Models\Cursos\Grupo;
use App\Models\Personas\TipoUsuario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AsignacionAlumno extends Model
{
    protected $table = 'asignacionesalumnos';

    protected $fillable = [
        'id_cursosciclolectivo',
        'id_tipousuario',
        'id_grupos',
        'estado',
    ];

    /**
     * The attributes default values.
     */
    protected $attributes = [
        'estado' => 'A', // Activo por defecto
    ];

    protected $casts = [
        'id_cursosciclolectivo' => 'integer',
        'id_tipousuario' => 'integer',
        'id_grupos' => 'integer',
    ];

    public function cursoCicloLectivo(): BelongsTo
    {
        return $this->belongsTo(CursoCicloLectivo::class, 'id_cursosciclolectivo');
    }

    public function tipoUsuario(): BelongsTo
    {
        return $this->belongsTo(TipoUsuario::class, 'id_tipousuario');
    }

    public function grupo(): BelongsTo
    {
        return $this->belongsTo(Grupo::class, 'id_grupos');
    }

    public function asistencias(): HasMany
    {
        return $this->hasMany(Asistencia::class, 'id_asignacionesalumnos');
    }

    //Scopes y Accessors

    public function scopeActivos($query)
    {
        return $query->where('estado', 'A');
    }

    public function scopeInactivos($query)
    {
        return $query->where('estado', 'I');
    }

    public function getEsActivoAttribute()
    {
        return $this->estado === 'A';
    }
}
