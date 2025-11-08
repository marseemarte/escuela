<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Materia;
use App\Models\Revista;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Planificacion extends Model
{
    use HasFactory;

    protected $table = 'planificaciones';

    protected $fillable = [
        'tamanio',
        'nombre_archivo',
        'ruta_archivo',
        'id_materia',
        'id_revista'
    ];

    protected $casts = [
        'tamanio' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relaciones
    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'id_materia');
    }

    public function revista(): BelongsTo
    {
        return $this->belongsTo(Revista::class, 'id_revista');
    }

    // Accessors
    public function getTamanioFormateadoAttribute()
    {
        $bytes = $this->tamanio;

        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }

        return $bytes . ' bytes';
    }

    public function getUrlArchivoAttribute()
    {
        return asset('storage/' . $this->ruta_archivo);
    }

    public function getExtensionAttribute()
    {
        return pathinfo($this->nombre_archivo, PATHINFO_EXTENSION);
    }

    // Scopes
    public function scopePorMateria($query, $materiaId)
    {
        return $query->where('id_materia', $materiaId);
    }

    public function scopePorRevista($query, $revistaId)
    {
        return $query->where('id_revista', $revistaId);
    }

    public function scopeMasRecientes($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
