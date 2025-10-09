<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';

    protected $fillable = [
        'usuario_id',
        'barbero_id',
        'fecha',
        'hora',
        'estado'
    ];

    // Definimos los nombres de las columnas de timestamps personalizados
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    // Relaciones
    public function cliente()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function barbero()
    {
        return $this->belongsTo(Barbero::class);
    }

    // Calcular total de servicios
    public function getTotalServiciosAttribute()
    {
        return $this->servicios->sum('pivot.precio');
    }

public function servicios()
{
    return $this->hasMany(ServicioReserva::class);
}

public function serviciosReserva()
{
    return $this->hasMany(ServicioReserva::class);
}
    public function venta()
    {
        return $this->hasOne(Venta::class, 'reserva_id');
    }

    // Método para calcular el total de servicios
    public function getTotalAttribute()
    {
        return $this->servicios->sum('pivot.precio');
    }

    // Método para verificar si tiene venta asociada
    public function getTieneVentaAttribute()
    {
        return $this->venta !== null;
    }
    
}
