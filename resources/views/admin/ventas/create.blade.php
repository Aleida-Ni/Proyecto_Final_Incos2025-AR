@extends('adminlte::page')
@section('title','Registrar venta')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection
@section('content')
<div class="row">
    <div class="col-md-8">
        <h4>Productos</h4>
        
        <!-- Barra de búsqueda -->
        <div class="mb-3">
            <input type="text" id="search-product" class="form-control" placeholder="Buscar producto...">
        </div>

        <!-- Pestañas de categorías -->
        <ul class="nav nav-tabs" id="categoriasTab" role="tablist">
            @foreach($productosPorCategoria as $categoria => $productos)
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                        id="{{ Str::slug($categoria) }}-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#{{ Str::slug($categoria) }}" 
                        type="button" role="tab" 
                        aria-controls="{{ Str::slug($categoria) }}" 
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                    {{ $categoria }} 
                    <span class="badge bg-secondary ms-1">{{ count($productos) }}</span>
                </button>
            </li>
            @endforeach
        </ul>

        <!-- Contenido de las pestañas -->
        <div class="tab-content p-3 border border-top-0" id="categoriasTabContent">
            @foreach($productosPorCategoria as $categoria => $productos)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                 id="{{ Str::slug($categoria) }}" 
                 role="tabpanel" 
                 aria-labelledby="{{ Str::slug($categoria) }}-tab">
                
                <div class="row product-container" data-categoria="{{ Str::slug($categoria) }}">
                    @foreach($productos as $p)
                    <div class="col-6 col-md-4 col-lg-3 mb-3 product-item" 
                         data-nombre="{{ strtolower($p->nombre) }}"
                         data-categoria="{{ Str::slug($categoria) }}">
                        <div class="card h-100 product-card">
                            @if($p->imagen)
                                <img src="{{ asset('storage/'.$p->imagen) }}" 
                                     class="card-img-top" 
                                     style="height:120px; object-fit:cover;"
                                     alt="{{ $p->nombre }}"
                                     onerror="this.style.display='none'">
                            @else
                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light" 
                                     style="height:120px;">
                                    <i class="fas fa-image text-muted fa-2x"></i>
                                </div>
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title mb-1 small">{{ Str::limit($p->nombre, 30) }}</h6>
                                <p class="mb-1 text-success fw-bold">Bs. {{ number_format($p->precio, 2) }}</p>
                                @if(isset($p->stock))
                                <small class="text-muted mb-2">Stock: {{ $p->stock }}</small>
                                @endif
                                <button class="btn btn-sm btn-primary btn-add mt-auto" 
                                        data-id="{{ $p->id }}" 
                                        data-nombre="{{ $p->nombre }}" 
                                        data-precio="{{ $p->precio }}"
                                        data-stock="{{ $p->stock ?? 0 }}"
                                        {{ (!isset($p->stock) || $p->stock > 0) ? '' : 'disabled' }}>
                                    <i class="fas fa-plus"></i> 
                                    {{ (!isset($p->stock) || $p->stock > 0) ? 'Agregar' : 'Sin stock' }}
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    @if(count($productos) === 0)
                    <div class="col-12 text-center py-4">
                        <p class="text-muted">No hay productos en esta categoría</p>
                    </div>
                    @endif
                </div>
                
            </div>
            @endforeach
        </div>
    </div>

    <div class="col-md-4">
        <h4>Ticket de Venta</h4>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Detalles de la Venta</h5>
                <small class="text-muted">Vendedor: {{ auth()->user()->nombre }} {{ auth()->user()->apellido_paterno }}</small>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Método de Pago</label>
                    <select id="metodo-pago" class="form-select">
                        <option value="efectivo">Efectivo</option>
                        <option value="tarjeta">Tarjeta</option>
                        <option value="transferencia">Transferencia</option>
                    </select>
                </div>

                <div class="mb-3" id="referencia-group" style="display: none;">
                    <label class="form-label">Referencia de Pago</label>
                    <input type="text" id="referencia-pago" class="form-control" placeholder="Número de referencia">
                </div>

                <hr>
                
                <table class="table table-sm" id="ticket-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th width="80">Cantidad</th>
                            <th width="100">Subtotal</th>
                            <th width="40"></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2">Total</th>
                            <th id="ticket-total" class="text-success">Bs. 0.00</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>

                <div class="mt-3">
                    <button id="btn-register-sale" class="btn btn-success w-100 btn-lg" disabled>
                        <i class="fas fa-cash-register"></i> Registrar Venta
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de éxito -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                <h5 class="text-success">¡Compra registrada con éxito!</h5>
                <p class="mb-0">Redirigiendo al detalle...</p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const items = [];
    
    // Inicializar pestañas de Bootstrap
    var categoriasTab = new bootstrap.Tab(document.getElementById('categoriasTab').querySelector('.nav-link'));
    
    // Toggle referencia de pago
    document.getElementById('metodo-pago').addEventListener('change', function() {
        const referenciaGroup = document.getElementById('referencia-group');
        referenciaGroup.style.display = this.value === 'efectivo' ? 'none' : 'block';
    });

    // Función para buscar productos
    document.getElementById('search-product').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase().trim();
        const activeTab = document.querySelector('#categoriasTabContent .tab-pane.active');
        const productItems = activeTab ? activeTab.querySelectorAll('.product-item') : [];
        
        productItems.forEach(item => {
            const productName = item.dataset.nombre;
            if (productName.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });

    function renderTicket(){
        const tbody = document.querySelector('#ticket-table tbody');
        tbody.innerHTML = '';
        let total = 0;
        
        items.forEach((it, idx) => {
            const subtotal = (it.precio * it.cantidad);
            total += subtotal;
            
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="small">${it.nombre}</td>
                <td>
                    <input type="number" min="1" value="${it.cantidad}" 
                           data-idx="${idx}" 
                           class="form-control form-control-sm qty-input">
                </td>
                <td class="small">Bs. ${subtotal.toFixed(2)}</td>
                <td>
                    <button class="btn btn-sm btn-outline-danger btn-remove" 
                            data-idx="${idx}" title="Quitar">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });
        
        document.getElementById('ticket-total').innerText = 'Bs. ' + total.toFixed(2);
        document.getElementById('btn-register-sale').disabled = items.length === 0;
    }

    // Agregar producto
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-add') || e.target.closest('.btn-add')) {
            const btn = e.target.classList.contains('btn-add') ? e.target : e.target.closest('.btn-add');
            
            if (btn.disabled) return;
            
            const id = parseInt(btn.dataset.id);
            const nombre = btn.dataset.nombre;
            const precio = parseFloat(btn.dataset.precio);
            const stock = parseInt(btn.dataset.stock) || 999;
            
            const existing = items.find(i => i.producto_id === id);
            
            if(existing){
                if(existing.cantidad < stock) {
                    existing.cantidad++;
                } else {
                    alert('Stock insuficiente para ' + nombre);
                    return;
                }
            } else {
                if(stock > 0) {
                    items.push({
                        producto_id: id, 
                        nombre: nombre, 
                        precio: precio, 
                        cantidad: 1
                    });
                } else {
                    alert('Sin stock para ' + nombre);
                    return;
                }
            }
            renderTicket();
        }
    });

    // Delegación para eventos del ticket
    document.getElementById('ticket-table').addEventListener('click', function(e){
        if(e.target.closest('.btn-remove')){
            const btn = e.target.closest('.btn-remove');
            const idx = parseInt(btn.dataset.idx);
            items.splice(idx, 1);
            renderTicket();
        }
    });
    
    document.getElementById('ticket-table').addEventListener('change', function(e){
        if(e.target.classList.contains('qty-input')){
            const idx = parseInt(e.target.dataset.idx);
            let val = parseInt(e.target.value) || 1;
            
            const productoId = items[idx].producto_id;
            const btn = document.querySelector(`.btn-add[data-id="${productoId}"]`);
            const stock = parseInt(btn?.dataset.stock) || 999;
            
            if(val > stock) {
                alert('Stock insuficiente. Máximo: ' + stock);
                val = stock;
                e.target.value = val;
            }
            
            items[idx].cantidad = val;
            renderTicket();
        }
    });

    // Registrar venta
    document.getElementById('btn-register-sale').addEventListener('click', function(){
        if(items.length === 0){ 
            alert('Agrega al menos un producto'); 
            return; 
        }
        
        const payload = {
            metodo_pago: document.getElementById('metodo-pago').value,
            referencia_pago: document.getElementById('referencia-pago').value || null,
            items: items
        };
        
        // Mostrar loading
        const btn = this;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
        btn.disabled = true;
        
        fetch("{{ route('admin.ventas.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            if(data.success){
                // Mostrar modal de éxito
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
                
                // Redirigir después de 2 segundos
                setTimeout(() => {
                    window.location.href = data.redirect_url;
                }, 2000);
            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error registrando la venta');
        })
        .finally(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    });

    // Inicializar
    renderTicket();
});
</script>

<style>
.product-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.nav-tabs .nav-link.active {
    font-weight: bold;
    background-color: #fff;
    border-bottom-color: #fff;
}

.qty-input {
    width: 70px;
}

.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.product-item {
    transition: all 0.3s ease;
}
</style>

<!-- Incluir Bootstrap JS si no está incluido -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection