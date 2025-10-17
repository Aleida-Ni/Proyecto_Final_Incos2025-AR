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


    public function reservas()
{
    return $this->belongsToMany(Reserva::class, 'servicio_reserva')
                ->withPivot('precio')
                ->withTimestamps();
}

public function serviciosReserva()
{
    return $this->hasMany(ServicioReserva::class);
}

        /**
         * Helper no destructivo para asociar este servicio a una reserva.
         * Si ya existe la fila, actualiza el precio, si no, la crea.
         *
         * @param  Reserva  $reserva
         * @param  float|null  $precio
         * @return void
         */
        public function attachToReserva(Reserva $reserva, $precio = null)
        {
            $precioAUsar = $precio ?? $this->precio;

            if ($reserva->serviciosModelos()->where('servicio_id', $this->id)->exists()) {
                $reserva->serviciosModelos()->updateExistingPivot($this->id, ['precio' => $precioAUsar]);
            } else {
                $reserva->serviciosModelos()->attach($this->id, ['precio' => $precioAUsar]);
            }
        }
}