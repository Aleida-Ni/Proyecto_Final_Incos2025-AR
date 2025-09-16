<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\VerifyEmailCustom;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

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
        'correo_verificado_en',
        'creado_en',
        'actualizado_en',
    ];

    protected $hidden = [
        'contrasenia',
        'remember_token',
    ];

    protected $casts = [
        'contrasenia'           => 'hashed',
        'correo_verificado_en'  => 'datetime',
        'creado_en'             => 'datetime',
        'actualizado_en'        => 'datetime',
        'estado'                => 'boolean',
    ];

    // Relación con reservas
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'user_id', 'id');
    }

    // Verificación de email
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

    // Autenticación: usa "correo" como identificador
    public function getAuthIdentifierName()
    {
        return 'correo';
    }

    public function getAuthPassword()
    {
        return $this->contrasenia;
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailCustom);
    }

    public function routeNotificationForMail($notification)
    {
        return $this->correo;
    }

    public function getEmailForVerification()
    {
        return $this->correo;
    }

    // Accesor para el nombre
    public function getNameAttribute()
    {
        return $this->attributes['nombre'];
    }

    // Roles
    public function can($ability, $arguments = [])
    {
        if ($ability === 'is-admin') return $this->rol === 'admin';
        if ($ability === 'is-cliente') return $this->rol === 'cliente';
        if ($ability === 'is-empleado') return $this->rol === 'empleado';
        return false;
    }
}
