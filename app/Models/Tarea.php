<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Tarea extends Model
{
    protected $table = 'tareas';

    protected $fillable = [
        'titulo',
        'descripcion', 
        'tamanio',
        'nombre_archivo',
        'ruta_archivo',
        'tipo', // Extensión/tipo de archivo (pdf, docx, etc.)
        'fecha_subida',
        'fecha_entrega',
        'id_revista'
    ];

    protected $casts = [
        'fecha_subida' => 'date',
        'fecha_entrega' => 'date', 
        'tamanio' => 'integer',
        'id_revista' => 'integer'
    ];

    // Relaciones
    public function revista(): BelongsTo
    {
        return $this->belongsTo(Revista::class, 'id_revista');
    }

    public function entregas(): HasMany
    {
        return $this->hasMany(TareaAlumno::class, 'id_tarea');
    }

    public function notas(): HasMany
    {
        return $this->hasMany(TareaNota::class, 'id_tarea');
    }

    public function visualizaciones(): HasMany
    {
        return $this->hasMany(ArchivoVisto::class, 'id_tarea');
    }

    // Scopes para filtrar tipos (basado en fecha_entrega)
    public function scopeModulos($query)
    {
        return $query->whereNull('fecha_entrega');
    }

    public function scopeTareasConEntrega($query) 
    {
        return $query->whereNotNull('fecha_entrega');
    }

    public function scopeDelProfesor($query, $profesorId)
    {
        return $query->whereHas('revista.tipoUsuario.persona', function($q) use ($profesorId) {
            $q->where('id', $profesorId);
        });
    }

    // Accessors
    public function esModulo(): Attribute
    {
        return Attribute::make(
            get: fn () => is_null($this->fecha_entrega)
        );
    }

    public function esTarea(): Attribute
    {
        return Attribute::make(
            get: fn () => !is_null($this->fecha_entrega)
        );
    }

    // Método para contar entregas
    public function contarEntregas()
    {
        return $this->entregas()->where('borrado_fisico', 0)->count();
    }

    // Método para contar alumnos que vieron la tarea
    public function contarVistos()
    {
        return $this->visualizaciones()
            ->where('visto', 1)
            ->where('tipo', 'T')
            ->distinct('id_asignacionesalumnos')
            ->count();
    }
}