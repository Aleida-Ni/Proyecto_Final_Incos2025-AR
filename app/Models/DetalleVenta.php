<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalles_venta';
    
    public $timestamps = false; // Si tu tabla no tiene timestamps

    protected $fillable = [
        'venta_id',
        'producto_id', // ← mantenerlo en fillable pero permitir null
        'servicio_id',
        'nombre_servicio', 
        'cantidad',
        'precio',
        'subtotal'
    ];
        protected $attributes = [
        'producto_id' => null,
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }
}