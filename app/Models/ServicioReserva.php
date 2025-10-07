<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioReserva extends Model
{
    use HasFactory;

    protected $table = 'servicio_reserva';
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';
    protected $fillable = [
        'reserva_id',
        'servicio_id',
        'precio'
    ];

    protected $casts = [
        'precio' => 'decimal:2'
    ];

    // Relación con Reserva
    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }

    // Relación con Servicio
public function servicio()
{
    return $this->belongsTo(Servicio::class);
}
}