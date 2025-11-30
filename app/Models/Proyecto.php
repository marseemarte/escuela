<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Revista;
use App\Models\Cupof;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyectos';

    protected $fillable = [
        'tamanio',
        'nombre_archivo',
        'ruta_archivo',
        'cupof',
        'id_revista',
    ];

    protected $casts = [
        'tamanio' => 'integer',
        'cupof' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relaciones
    public function cupof(): BelongsTo
    {
        return $this->belongsTo(Cupof::class, 'cupof', 'cupof');
    }

    public function revista(): BelongsTo
    {
        return $this->belongsTo(Revista::class, 'id_revista');
    }

    // Accesors y mutadores
    public function profesor()
    {
        return $this->hasOneThrough(
            \App\Models\Personas\Persona::class,
            Revista::class,
            'id', // Foreign key en revista
            'id', // Foreign key en persona
            'id_revista', // Local key en proyectos
            'id_tipousuario' // Local key en revista
        );
    }

    public function getTamanioFormateadoAttribute()
    {
        $bytes = $this->tamanio;

        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }

        return $bytes . ' bytes';
    }

    public function getExtensionAttribute()
    {
        return strtolower(pathinfo($this->nombre_archivo, PATHINFO_EXTENSION));
    }

    public function getIconoAttribute()
    {
        $iconos = [
            'pdf' => 'fa-file-pdf text-danger',
            'doc' => 'fa-file-word text-primary',
            'docx' => 'fa-file-word text-primary',
            'xls' => 'fa-file-excel text-success',
            'xlsx' => 'fa-file-excel text-success',
            'ppt' => 'fa-file-powerpoint text-warning',
            'pptx' => 'fa-file-powerpoint text-warning',
            'zip' => 'fa-file-archive text-secondary',
            'rar' => 'fa-file-archive text-secondary',
        ];

        return $iconos[$this->extension] ?? 'fa-file text-muted';
    }

    public function getColorBadgeAttribute()
    {
        $colores = [
            'pdf' => 'danger',
            'doc' => 'primary',
            'docx' => 'primary',
            'xls' => 'success',
            'xlsx' => 'success',
            'ppt' => 'warning',
            'pptx' => 'warning',
            'zip' => 'secondary',
            'rar' => 'secondary',
        ];

        return $colores[$this->extension] ?? 'secondary';
    }

    public function getRutaCompletaAttribute()
    {
        return storage_path('app/private/' . $this->ruta_archivo);
    }

    public function archivoExiste()
    {
        return file_exists($this->ruta_completa);
    }

    public function getNombreProfesorAttribute()
    {
        if ($this->revista && $this->revista->tipoUsuario && $this->revista->tipoUsuario->persona) {
            $persona = $this->revista->tipoUsuario->persona;
            return trim($persona->apellido . ', ' . $persona->nombre);
        }
        return 'Desconocido';
    }

    public function getInfoMateriaAttribute()
    {
        if ($this->cupofRelacion) {
            $cupof = $this->cupofRelacion;
            $materia = $cupof->materia->nombre ?? 'Sin materia';
            $curso = ($cupof->curso->ano ?? '') . '° ' . ($cupof->curso->division ?? '');
            $grupo = $cupof->grupo->nombre ?? '';

            return "{$materia} - {$curso} {$grupo}";
        }
        return 'Sin información';
    }

    public function scopePorCupof($query, $cupof)
    {
        return $query->where('cupof', $cupof);
    }

    public function scopePorRevista($query, $revistaId)
    {
        return $query->where('id_revista', $revistaId);
    }

    public function scopePorProfesor($query, $dni)
    {
        return $query->whereHas('revista.tipousuario.persona', function ($q) use ($dni) {
            $q->where('dni', $dni);
        });
    }

    public function scopeMasRecientes($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeBuscarPorTitulo($query, $termino)
    {
        return $query->where('titulo', 'like', "%{$termino}%");
    }

    public function scopePorExtension($query, $extension)
    {
        return $query->where('nombre_archivo', 'like', "%.{$extension}");
    }

    protected static function boot()
    {
        parent::boot();

        // Al eliminar un proyecto, eliminar también el archivo físico
        static::deleting(function ($proyecto) {
            if ($proyecto->archivoExiste()) {
                @unlink($proyecto->ruta_completa);
            }
        });
    }
}
