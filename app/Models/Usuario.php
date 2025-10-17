<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Log;

class Usuario extends Authenticatable implements MustVerifyEmail
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
            'correo_verificado_en' => $this->freshTimestamp(),
        ])->save();
    }

    public function sendEmailVerificationNotification()
    {
        try {
            $this->notify(new \App\Notifications\VerifyEmailCustom);
        } catch (\Exception $e) {
            // Registrar el error y continuar para no bloquear el registro del usuario
            Log::error('Error enviando email de verificación: '.$e->getMessage(), ['user_id' => $this->id ?? null]);
        }
    }

    public function getEmailForVerification()
    {
        return $this->correo;
    }

    // Para usar "correo" en lugar de "email"
    public function routeNotificationForMail($notification)
    {
        return $this->correo;
    }

    public function adminlte_desc()
    {
        return ucfirst($this->rol);
    }

    public function adminlte_image()
    {
        return asset('images/user-default.png');
    }

    public function adminlte_profile_url()
    {
        return route('profile.show');
    }

    // Relaciones
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'usuario_id');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'usuario_id');
    }

    // Getters
    public function getAuthPassword()
    {
        return $this->contrasenia;
    }

    public function getEmailForPasswordReset()
    {
        return $this->correo;
    }

    public function getNameAttribute()
    {
        return $this->nombre . ' ' . $this->apellido_paterno;
    }

    // Roles
    public function hasRole($role)
    {
        return $this->rol === $role;
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isEmpleado()
    {
        return $this->hasRole('empleado');
    }

    public function isCliente()
    {
        return $this->hasRole('cliente');
    }

    // Nombres completos
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}";
    }
}