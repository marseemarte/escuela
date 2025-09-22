<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\DB;

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

    // Método para contar entregas realizadas (solo para tareas con fecha de entrega)
    public function contarEntregas()
    {
        if (is_null($this->fecha_entrega)) {
            return 0; // Los módulos no tienen entregas
        }

        return DB::table('tareas_alumnos')
            ->where('id_tarea', $this->id)
            ->where('borrado_fisico', 0)
            ->count();
    }

    // Método para contar alumnos que vieron la tarea
    public function contarVistos()
    {
        return DB::table('archivos_visto')
            ->where('id_tarea', $this->id)
            ->where('visto', 1)
            ->distinct('id_asignacionesalumnos')
            ->count();
    }

    // Método para obtener total de alumnos del curso
    public function contarTotalAlumnosCurso()
    {
        // Obtener el curso a través de la revista
        $revista = $this->revista;
        if (!$revista) {
            return 0;
        }

        $cupof = $revista->cupof;
        if (!$cupof) {
            return 0;
        }

        $cupofModel = Cupof::with('curso')->find($cupof);
        if (!$cupofModel || !$cupofModel->curso) {
            return 0;
        }

        return DB::table('asignacionesalumnos as aa')
            ->join('cursociclolectivo as ccl', 'aa.id_cursosciclolectivo', '=', 'ccl.id')
            ->where('ccl.id_cursos', $cupofModel->curso->id)
            ->where('ccl.ciclolectivo', date('Y'))
            ->where('aa.estado', 'A')
            ->count();
    }

    // Método para obtener estadísticas formateadas
    public function obtenerEstadisticas()
    {
        $totalAlumnos = $this->contarTotalAlumnosCurso();
        $vistos = $this->contarVistos();
        
        if ($this->esModulo) {
            return [
                'vistos' => $vistos . '/' . $totalAlumnos,
                'entregas' => null // Los módulos no tienen entregas
            ];
        } else {
            $entregas = $this->contarEntregas();
            return [
                'vistos' => $vistos . '/' . $totalAlumnos,
                'entregas' => $entregas . '/' . $totalAlumnos
            ];
        }
    }
}