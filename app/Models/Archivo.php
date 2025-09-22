<?php

use App\Models\Personas\Persona;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;

    protected $table = 'archivos';

    protected $fillable = [
        'nombre',
        'ruta',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(Persona::class);
    }
}
