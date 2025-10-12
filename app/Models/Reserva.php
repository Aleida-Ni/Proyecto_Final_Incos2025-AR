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
        'estado',
        'metodo_pago',
        'observaciones',
        'creado_en',
        'actualizado_en'
    ];

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $dates = [
        'fecha',
        'creado_en',
        'actualizado_en'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Alias para usuario() para mantener compatibilidad
    public function cliente()
    {
        return $this->usuario();
    }

    public function barbero()
    {
        return $this->belongsTo(Barbero::class, 'barbero_id');
    }

    public function servicios()
    {
        return $this->hasMany(ServicioReserva::class);
    }

    // Relación directa con servicios a través de la tabla pivot
    public function serviciosDirectos()
    {
        return $this->belongsToMany(Servicio::class, 'servicio_reserva', 'reserva_id', 'servicio_id')
                    ->withPivot('precio')
                    ->withTimestamps();
    }

    public function venta()
    {
        return $this->hasOne(Venta::class, 'reserva_id');
    }

    // Método para calcular el total
    public function getTotalAttribute()
    {
        if ($this->venta) {
            return $this->venta->total;
        }
        
        return $this->servicios->sum('precio');
    }

    public function getTieneVentaAttribute()
    {
        return $this->venta !== null;
    }
}