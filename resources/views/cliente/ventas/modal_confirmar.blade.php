<div class="modal fade" id="modalConfirmarCompra" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title">Pedido Pendiente</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <p><strong>Código:</strong> {{ $venta->codigo }}</p>
                <p><strong>Total:</strong> Bs. {{ number_format($venta->total, 2) }}</p>

                <h5>Escanea el QR para guardar o mostrar comprobante</h5>
                {!! $qrSvg !!}

                <h5>Comprobante de Pago</h5>
                <p>Una vez confirmado, tu pedido será procesado.</p>

                <hr>
                <h6>Detalle</h6>
                <ul class="list-unstyled">
                    @foreach($venta->detalles as $det)
                        <li>{{ $det->producto->nombre }} — {{ $det->cantidad }} x Bs. {{ number_format($det->precio,2) }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
