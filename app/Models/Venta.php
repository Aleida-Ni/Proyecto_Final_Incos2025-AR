<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'reserva_id',
        'usuario_id',
        'empleado_id',
        'estado',
        'metodo_pago',
        'referencia_pago',
        'fecha_pago',
        'codigo',
        'total',
    ];

    // Relaciones
    public function cliente()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function empleado()
    {
        return $this->belongsTo(User::class, 'empleado_id');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'venta_id');
    }

    // Scopes útiles
    public function scopeCompletadas($query)
    {
        return $query->where('estado', 'completada');
    }

    public function scopeAnuladas($query)
    {
        return $query->where('estado', 'anulada');
    }

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }

    public function scopeHoy($query)
    {
        return $query->whereDate('creado_en', today());
    }

    // Accesores
    public function getTotalFormateadoAttribute()
    {
        return '$ ' . number_format($this->total, 2);
    }

    public function getFechaFormateadaAttribute()
    {
        return $this->creado_en->format('d/m/Y H:i');
    }

    public function getEstadoBadgeAttribute()
    {
        $badges = [
            'completada' => 'success',
            'anulada' => 'danger',
            'pendiente' => 'warning'
        ];

        $color = $badges[$this->estado] ?? 'secondary';
        return "<span class='badge badge-{$color}'>" . ucfirst($this->estado) . "</span>";
    }
    
}