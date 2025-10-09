<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barbero extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'correo',
        'telefono',
        'cargo',
        'imagen',
        'estado',

        
    ];
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';
public function scopeActivos($query)
{
    return $query->where('estado', 1);
}
    // Accesor para nombre completo
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}";
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class);
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
