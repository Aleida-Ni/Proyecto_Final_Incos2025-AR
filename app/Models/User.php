<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
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
        'contrasenia',
        'rol',
        'fecha_nacimiento',
        'estado',
        'creado_en',
        'actualizado_en',
    ];

    protected $hidden = [
        'contrasenia',
        'remember_token',
    ];

    protected $casts = [
        'correo_verificado_en' => 'datetime',
        'contrasenia' => 'hashed',
    ];

    // Relación
    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    // Para que Laravel use "correo" en lugar de "email"
    public function getAuthIdentifierName()
    {
        return 'correo';
    }

    // Para notificaciones generales
    public function routeNotificationForMail($notification)
    {
        return $this->correo;
    }

    // Para verificación de correo (solo clientes)
    public function getEmailForVerification()
    {
        return $this->correo;
    }

    // 👇 Aquí está la clave para usar "contrasenia"
    public function getAuthPassword()
    {
        return $this->contrasenia;
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
