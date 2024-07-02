@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="alert alert-success fade show" id="success-message"
    data-bs-dismiss="alert" role="alert">
    {{ session('success')}}
</div>
@endif
  <h1>Lista de Asistencia</h1>

  <form action="{{ route('asistencias_est.index')}}" method="GET">
    @csrf
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Grupo</th>
                <th>Fecha</th>
                <th>Hora entrada</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($asistencias_est as $asistencia_est)
                <tr>
                    <td>{{ $asistencia_est->estudiante->nombre }} {{ $asistencia_est->estudiante->apellido }}</td>
                    <td>{{ $asistencia_est->grupo->nombre }}</td>
                    <td>{{ $asistencia_est->fecha }}</td>
                    <td>{{ $asistencia_est->hora_entrada }}</td>
                    <td>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="row mt-2">
        <div class="col-md-12">
            <a href="{{ route('asistencias_est.create') }}" class="btn btn-link">Ir a crear</a>
        </div>
    </div>
    </div>
</form>
@endsection