<?php

namespace App\Models\Personas;

use Database\Factories\PersonaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class Persona extends Authenticatable
{
    use HasFactory, Notifiable;

    protected static function newFactory()
    {
        return PersonaFactory::new();
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
        'mail', // Agregar mail a fillable
    ];

    protected $casts = [
        'fechan' => 'date',
        'email_verified_at' => 'datetime',
        'pass' => 'hashed', // Hashing para contraseñas
        'dni' => 'integer',
        'id_localidad' => 'integer',
    ];

    protected $hidden = [
        'pass',
        'remember_token',
    ];

    // Relaciones
    public function tiposUsuario(): HasMany
    {
        return $this->hasMany(TipoUsuario::class, 'id_persona');
    }

    /**
     * Determine si la persona tiene el tipo 'Personal' (profesor).
     */
    public function isProfesor(): bool
    {
        return $this->tiposUsuario()
            ->whereHas('tipoPersona', function ($q) {
                $q->where('tipo', 'Profesor');
            })
            ->exists();
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

    public function getDniFormattedAttribute()
    {
        return number_format($this->dni, 0, '', '.');
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

    public function getAuthPassword()
    {
        return $this->pass;
    }

    public function getAuthIdentifier()
    {
        return $this->mail;
    }

    public function getAuthIdentifierName()
    {
        return 'mail'; // Usar 'mail' en lugar de 'email'
    }

    public function getAuthPasswordName()
    {
        return 'pass'; // Usar 'pass' en lugar de 'password'
    }

    public function getEmailForPasswordReset()
    {
        return $this->mail;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['pass'] = $value;
    }

    public function setPassAttribute($value)
    {
        $this->attributes['pass'] = Hash::make($value);
    }
}
