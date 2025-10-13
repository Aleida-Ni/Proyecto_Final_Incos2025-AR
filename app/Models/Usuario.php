<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
    public function adminlte_desc()
    {
        // Retorna el rol o alguna descripción
        return ucfirst($this->rol); // Ej: "Admin", "Cliente", etc.
    }
        public function adminlte_image()
    {
        // Si tienes campo de imagen, retorna la URL
        // Si no, retorna una imagen por defecto
        return asset('images/user-default.png');
    }
        public function adminlte_profile_url()
    {
        return route('profile.show');
    }
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

    public function getEmailForVerification()
    {
        return $this->correo;
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