@extends('cliente.layout')

@section('title', 'Reservar con ' . $barbero->nombre)

@push('css')
<style>
  body, .wrapper, .content-wrapper, .main-header, .main-sidebar, .content, .main-footer {
    background-color: #000 !important;
    color: #fff !important;
  }

  .card-custom {
    background-color: #111;
    border-radius: 12px;
    padding: 20px;
    color: #fff;
  }
  #selectorFecha {
    background-color: #111 !important;
    color: #fff !important;
    border: 1px solid #dc3545;
    border-radius: 5px;
    padding: 6px 12px;
}

  .barbero-img {
    max-width: 100%;
    height: auto;
    border-radius: 12px;
    border: 2px solid #0d6efd; /* azul */
  }

  .hora-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr); /* 5 columnas para cuadrados */
    gap: 10px;
  }

  .hora-disponible,
  .hora-no-disponible {
    width: 100%;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    border-radius: 6px;
    font-size: 13px;
    user-select: none;
    text-align: center;
  }

  .hora-disponible {
    border: 2px solid #0d6efd;
    color: #fff;
    cursor: pointer;
    transition: background-color .2s, transform .2s;
  }

  .hora-disponible:hover,
  .hora-disponible.selected {
    background-color: #0d6efd;
    transform: scale(1.05);
  }

  .hora-no-disponible {
    background-color: #330000;
    border: 2px solid #ff0000;
    color: #fff;
    cursor: not-allowed;
  }

  .btn-confirmar {
    background-color: #dc3545;
    color: #fff;
    padding: 10px 30px;
    font-size: 16px;
    border-radius: 8px;
    border: none;
  }

  .btn-elegir-dia {
    border: 1px solid #dc3545;
    color: #fff;
    background-color: transparent;
    border-radius: 5px;
    padding: 6px 12px;
  }

  .modal-content {
    background-color: #111;
    color: #fff;
  }

  label, .form-control {
    color: #fff !important;
  }
</style>
@endpush

@section('content')
<div class="container-fluid p-4">
  <div class="card card-custom mx-auto" style="max-width:1000px;">
    <h3 class="text-center mb-4">Reservar con {{ $barbero->nombre }}</h3>

    <div class="row">
      <div class="col-md-4 text-center">
        <img src="{{ asset('storage/' . $barbero->imagen) }}" 
             alt="Foto de {{ $barbero->nombre }}" 
             class="barbero-img mb-3">
        <h4 class="text-white mt-2">{{ $barbero->nombre }}</h4>
        <p class="text-muted">{{ $barbero->cargo }}</p>
      </div>

      <div class="col-md-8">
        <form action="{{ route('cliente.reservar.store') }}" method="POST" id="formReserva">
          @csrf
          <input type="hidden" name="barbero_id" value="{{ $barbero->id }}">
          <input type="hidden" name="fecha" id="fechaInput" value="{{ $fecha }}">
          <input type="hidden" name="hora" id="horaInput">

          <div class="d-flex justify-content-between align-items-center mb-4">
            <div><strong>Fecha seleccionada:</strong> <span id="fechaSeleccionada">{{ $fecha }}</span></div>
            <button type="button" class="btn btn-elegir-dia" data-bs-toggle="modal" data-bs-target="#modalFecha">
              Elegir Día
            </button>
          </div>

          @if($errors->has('hora'))
          <div class="text-danger text-center mb-3">{{ $errors->first('hora') }}</div>
          @endif

          <div class="hora-grid mb-4">
            @foreach($horas as $hora => $disponible)
              @if($disponible)
                <label class="hora-disponible">
                  <input type="radio" name="horaRadio" value="{{ $hora }}" hidden>
                  {{ $hora }}
                </label>
              @else
                <div class="hora-no-disponible">Hora no disponible<br>{{ $hora }}</div>
              @endif
            @endforeach
          </div>

          <div class="text-center">
            <button type="button" class="btn-confirmar" id="btnConfirmar">Confirmar Reserva</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Fecha -->
  <div class="modal fade" id="modalFecha" tabindex="-1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content bg-dark text-white">
        <div class="modal-header border-0">
          <h5 class="modal-title">Seleccionar Fecha</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="date" id="selectorFecha" class="form-control" min="{{ date('Y-m-d') }}" value="{{ $fecha }}">
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-danger" onclick="setFecha()">Confirmar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Ticket -->
  <div class="modal fade" id="modalTicket" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content bg-dark text-white">
        <div class="modal-header">
          <h5 class="modal-title">Ticket de Reserva</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="ticket-content">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" onclick="window.print()">Imprimir</button>
          <button type="button" class="btn btn-primary" id="confirmarTicket">Confirmar</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
function setFecha() {
  const valor = document.getElementById('selectorFecha').value;
  if(valor) {
    const barberoId = "{{ $barbero->id }}";
    window.location.href = `/cliente/reservar/${barberoId}?fecha=${valor}`;
  } else {
    alert("Selecciona una fecha válida.");
  }
}

document.addEventListener('DOMContentLoaded', () => {

  const horaInputs = document.querySelectorAll('.hora-disponible input[type=radio]');
  const horaInputHidden = document.getElementById('horaInput');

  document.querySelectorAll('.hora-disponible').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.hora-disponible').forEach(b => b.classList.remove('selected'));
      btn.classList.add('selected');
      btn.querySelector('input[type=radio]').checked = true;
    });
  });

  document.getElementById('btnConfirmar').addEventListener('click', () => {
    const selected = document.querySelector('input[name="horaRadio"]:checked');
    if(!selected) return alert("Por favor selecciona una hora disponible.");

    horaInputHidden.value = selected.value;

    const ticketContent = document.getElementById('ticket-content');
    ticketContent.innerHTML = `
      <h3>Ticket de Reserva</h3>
      <p><strong>Barbero:</strong> {{ $barbero->nombre }}</p>
      <p><strong>Fecha:</strong> ${document.getElementById('fechaInput').value}</p>
      <p><strong>Hora:</strong> ${selected.value}</p>
      <p><strong>Cliente:</strong> {{ auth()->user()->nombre }} {{ auth()->user()->apellido_paterno }}</p>
    `;

    const modalTicket = new bootstrap.Modal(document.getElementById('modalTicket'));
    modalTicket.show();
  });

  document.getElementById('confirmarTicket').addEventListener('click', () => {
    document.getElementById('formReserva').submit();
  });

  document.querySelectorAll('.hora-no-disponible').forEach(btn => {
    btn.addEventListener('click', () => { alert('Esta hora ya ha sido reservada. Por favor, elige otra.'); });
  });
});
</script>
@endpush
