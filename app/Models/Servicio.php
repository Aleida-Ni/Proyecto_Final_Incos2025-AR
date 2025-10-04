<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'duracion_minutos',
        'activo'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'activo' => 'boolean'
    ];

    // Relación con reservas
    public function reservas()
    {
        return $this->belongsToMany(Reserva::class, 'servicio_reserva')
                    ->withPivot('precio')
                    ->withTimestamps();
    }
}