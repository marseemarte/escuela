<?php

namespace App\Models\Personas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Persona extends Authenticatable
{
    use HasFactory, Notifiable;

    protected static function newFactory()
    {
        return \Database\Factories\PersonaFactory::new();
    }

    protected $table = 'persona';

    protected $fillable = [
        'dni',
        'apellido',
        'nombre',
        'fechan',
        'sexo',
        'domicilio',
        'id_localidad',
        'pass',
        'telefono',
        'mail',
    ];

    protected $casts = [
        'fechan' => 'date',
        'email_verified_at' => 'datetime',
        'pass' => 'hashed', // Mejorado: usar hashing apropiado
        'dni' => 'integer',
        'id_localidad' => 'integer',
    ];

    protected $hidden = [
        'pass',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->pass;
    }

    public function getEmailForPasswordReset()
    {
        return $this->mail;
    }

    public function tiposUsuario(): HasMany
    {
        return $this->hasMany(TipoUsuario::class, 'id_persona');
    }

    // Scopes y Accessors
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }

    public function initials(): string
    {
        return Str::of($this->nombre_completo)
            ->explode(' ')
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function getNameAttribute()
    {
        return $this->nombre_completo;
    }

    public function getEmailAttribute()
    {
        return $this->mail;
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['mail'] = $value;
    }

    public function getPasswordAttribute()
    {
        return $this->pass;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['pass'] = $value;
    }
}
