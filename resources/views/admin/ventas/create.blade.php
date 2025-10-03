@extends('adminlte::page')
@section('title','Registrar venta')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h4>Productos</h4>
        <div class="row">
            @foreach($productos as $p)
            <div class="col-6 col-md-4 mb-3">
                <div class="card h-100">
                    @if($p->imagen)
                        <img src="{{ asset('storage/'.$p->imagen) }}" class="card-img-top" style="height:120px; object-fit:cover;">
                    @endif
                    <div class="card-body">
                        <h6 class="card-title mb-1">{{ $p->nombre }}</h6>
                        <p class="mb-1">Bs. {{ number_format($p->precio,2) }}</p>
                        <button class="btn btn-sm btn-primary btn-add" data-id="{{ $p->id }}" data-nombre="{{ $p->nombre }}" data-precio="{{ $p->precio }}">Agregar</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="col-md-4">
        <h4>Ticket</h4>

        <div class="card p-3">
            <div class="mb-2">
                <label>Cliente (opcional)</label>
                <select id="cliente-select" class="form-control">
                    <option value="">-- Cliente no registrado --</option>
                    @foreach($clientes as $c)
                        <option value="{{ $c->id }}">{{ $c->nombre }} {{ $c->apellido_paterno }}</option>
                    @endforeach
                </select>
            </div>

            <table class="table table-sm" id="ticket-table">
                <thead><tr><th>Prod</th><th>Qty</th><th>Subtotal</th><th></th></tr></thead>
                <tbody></tbody>
                <tfoot>
                    <tr><th colspan="2">Total</th><th id="ticket-total">Bs. 0.00</th><th></th></tr>
                </tfoot>
            </table>

            <div class="mt-2">
                <button id="btn-register-sale" class="btn btn-success w-100">Registrar Venta</button>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const items = []; // {producto_id, nombre, precio, cantidad}
    function renderTicket(){
        const tbody = document.querySelector('#ticket-table tbody');
        tbody.innerHTML = '';
        let total = 0;
        items.forEach((it, idx) => {
            const tr = document.createElement('tr');
            const subtotal = (it.precio * it.cantidad);
            total += subtotal;
            tr.innerHTML = `<td>${it.nombre}</td>
                            <td><input type="number" min="1" value="${it.cantidad}" data-idx="${idx}" class="form-control form-control-sm qty-input" style="width:70px;"></td>
                            <td>Bs. ${subtotal.toFixed(2)}</td>
                            <td><button class="btn btn-sm btn-danger btn-remove" data-idx="${idx}">&times;</button></td>`;
            tbody.appendChild(tr);
        });
        document.getElementById('ticket-total').innerText = 'Bs. ' + total.toFixed(2);
    }

    // agregar producto
    document.querySelectorAll('.btn-add').forEach(btn => {
        btn.addEventListener('click', function(){
            const id = this.dataset.id;
            const nombre = this.dataset.nombre;
            const precio = parseFloat(this.dataset.precio);
            const existing = items.find(i => i.producto_id == id);
            if(existing){
                existing.cantidad++;
            } else {
                items.push({producto_id: id, nombre: nombre, precio: precio, cantidad: 1});
            }
            renderTicket();
        });
    });

    // delegación para quitar y cambiar qty
    document.getElementById('ticket-table').addEventListener('click', function(e){
        if(e.target.classList.contains('btn-remove')){
            const idx = parseInt(e.target.dataset.idx);
            items.splice(idx,1);
            renderTicket();
        }
    });
    document.getElementById('ticket-table').addEventListener('change', function(e){
        if(e.target.classList.contains('qty-input')){
            const idx = parseInt(e.target.dataset.idx);
            let val = parseInt(e.target.value) || 1;
            items[idx].cantidad = val;
            renderTicket();
        }
    });

    // registrar venta
    document.getElementById('btn-register-sale').addEventListener('click', function(){
        if(items.length === 0){ alert('Agrega al menos un producto'); return; }
        const payload = {
            cliente_id: document.getElementById('cliente-select').value || null,
            items: items
        };
        fetch("{{ route('admin.ventas.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(payload)
        }).then(res => {
            if(res.redirected){
                window.location.href = res.url;
                return;
            }
            return res.json();
        }).then(data => {
            if(data && data.error){
                alert('Error: ' + data.error);
            }
        }).catch(err => {
            console.error(err);
            alert('Error registrando la venta');
        });
    });

});
</script>
@endsection
