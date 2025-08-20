<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'correo',
        'telefono',
        'contraseña',
        'rol',
        'fecha_nacimiento',
        'creado_en',
        'actualizado_en',
    ];

    protected $hidden = [
        'contraseña',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'contraseña' => 'hashed',
    ];

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    // Para que Laravel use "correo" en lugar de "email"
    public function getAuthIdentifierName()
    {
        return 'correo';
    }

    // Para notificaciones generales (ej: reset de contraseña)
    public function routeNotificationForMail($notification)
    {
        return $this->correo;
    }

    // Para verificación de correo
    public function getEmailForVerification()
    {
        return $this->correo;
    }

    // Para que Laravel use "contraseña" en lugar de "password"
    public function getAuthPassword()
    {
        return $this->contraseña;
    }

    public function getNameAttribute()
    {
        return $this->attributes['nombre'];
    }

    /**
     * Método can() personalizado para roles en AdminLTE.
     */
    public function can($ability, $arguments = [])
    {
        if ($ability === 'is-admin') {
            return $this->rol === 'admin';
        }

        if ($ability === 'is-cliente') {
            return $this->rol === 'cliente';
        }

        if ($ability === 'is-empleado') {
            return $this->rol === 'empleado';
        }

        return false;
    }
}
