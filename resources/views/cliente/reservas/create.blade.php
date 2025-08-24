@extends('cliente.layout')

@section('title', 'Reservar con ' . $barbero->nombre)

@push('css')
<style>
  body, .wrapper, .content-wrapper, .main-header, .main-sidebar, .content, .main-footer {
    color: #fff !important;
  }

  .card-custom 
  { 
    background-color: #111; 
    border-radius: 12px; 
  }
  .hora-grid 
  { 
    display: grid; 
    grid-template-columns: repeat(3, 1fr); gap: 10px; 
  }
  .hora-disponible, 
  .hora-no-disponible
   {
    height: 40px; 
    display: flex; 
    align-items: center; 
    justify-content: center;
    font-weight: bold; 
    border-radius: 6px; 
    font-size: 14px; 
    cursor: pointer; 
    user-select: none;
  }
  .hora-disponible { border: 2px solid #28a745; color: #fff; transition: background-color .2s; }
  .hora-disponible:hover, .hora-disponible.selected { background-color: #28a745; }
  .hora-no-disponible { background-color: #330000; border: 2px solid #ff0000; color: #fff; cursor: not-allowed; }
  .btn-confirmar { background-color: #dc3545; color: #fff; padding: 10px 30px; font-size: 16px; border-radius: 8px; border: none; }
  .btn-elegir-dia { border: 1px solid #dc3545; color: #fff; background-color: transparent; border-radius: 5px; padding: 6px 12px; }
  .modal-content { background-color: #111; color: #fff; }
</style>
@endpush

@section('content')
<div class="container-fluid p-4">
  <div class="card card-custom p-4 mx-auto" style="max-width:800px;">
    <h3 class="text-center mb-4">Reservar con {{ $barbero->nombre }}</h3>

    <form action="{{ route('cliente.reservar.store') }}" method="POST" id="formReserva">
      @csrf
      <input type="hidden" name="barbero_id" value="{{ $barbero->id }}">
      <input type="hidden" name="fecha" id="fechaInput" value="{{ $fecha }}">

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
              <input type="radio" name="hora" value="{{ $hora }}" required hidden>
              {{ $hora }}
            </label>
          @else
            <div class="hora-no-disponible">{{ $hora }}</div>
          @endif
        @endforeach
      </div>

      <div class="text-center">
        <button type="submit" class="btn-confirmar">Confirmar Reserva</button>
      </div>
    </form>
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
</div>
@endsection

@push('js')
<script>
function setFecha() {
  const valor = document.getElementById('selectorFecha').value;
  if(valor) {
    const barberoId = {{ $barbero->id }};
    window.location.href = `/cliente/reservar/${barberoId}?fecha=${valor}`;
  } else alert("Selecciona una fecha válida.");
}

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.hora-disponible').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.hora-disponible').forEach(b => b.classList.remove('selected'));
      btn.classList.add('selected');
      btn.querySelector('input[type=radio]').checked = true;
    });
  });

  document.getElementById('formReserva').addEventListener('submit', e => {
    const selected = document.querySelector('input[name="hora"]:checked');
    if(!selected) { e.preventDefault(); alert("Por favor selecciona una hora disponible."); }
  });

  document.querySelectorAll('.hora-no-disponible').forEach(btn => {
    btn.addEventListener('click', () => { alert('Esta hora ya ha sido reservada. Por favor, elige otra.'); });
  });
});
</script>
@endpush
