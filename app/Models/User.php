<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';
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

    // Verificación de correo
    public function hasVerifiedEmail()
    {
        return !is_null($this->correo_verificado_en);
    }

    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'correo_verificado_en' => now(),
        ])->save();
    }

    // Relación con reservas
    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    // Para notificaciones por correo
    public function routeNotificationForMail($notification)
    {
        return $this->correo;
    }

    public function getEmailForVerification()
    {
        return $this->correo;
    }

    // Para usar "contrasenia" en lugar de "password"
    public function getAuthPassword()
    {
        return $this->contrasenia;
    }

    // Getter del nombre completo opcional
    public function getNameAttribute()
    {
        return $this->attributes['nombre'];
    }

    /**
     * Obtener la descripción del usuario para AdminLTE.
     *
     * @return string
     */
    public function adminlte_desc()
    {
        return ucfirst($this->rol);
    }

    /**
     * Obtener la imagen del usuario para AdminLTE.
     *
     * @return string
     */
    public function adminlte_image()
    {
        return 'vendor/adminlte/dist/img/user2-160x160.jpg';
    }

    /**
     * Obtener el perfil URL para AdminLTE.
     *
     * @return string|false
     */
    public function adminlte_profile_url()
    {
        return route('admin.settings');
    }

    // Método para verificar roles
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

    // Enviar notificación de verificación personalizada
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\VerifyEmailCustom);
    }
}
