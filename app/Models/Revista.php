<?php

namespace App\Models;

use App\Models\Personas\TipoUsuario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'cupof' => 'integer',
        'id_tipousuario' => 'integer',
        'fd' => 'date',
        'fh' => 'date',
        'secuencia' => 'integer',
        'situacion' => 'string',
        'estado' => 'string',
    ];

    // Relaciones

    public function tipoUsuario(): BelongsTo
    {
        return $this->belongsTo(TipoUsuario::class, 'id_tipousuario');
    }

    public function cupof(): BelongsTo
    {
        return $this->belongsTo(Cupof::class, 'cupof');
    }
}
