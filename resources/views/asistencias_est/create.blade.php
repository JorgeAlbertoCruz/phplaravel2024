@extends('layouts.app')

@section('content')

@if (session('success'))
    <div class="alert alert-success fade show m-2" id="success-message" data-bs-dismiss="alert" role="alert">
        {{ session('success') }}
    </div>
@endif

<h1>Marcar Asistencia</h1>
<form action="{{ route('asistencias_est.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-5">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <label for="pin" class="form-label">Pin</label>
            <input type="password" class="form-control" id="pin" name="pin" required>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <button type="submit" class="btn btn-success">Confirmar</button>
            <a href="{{ route('docentes.login') }}" class="btn btn-link">Ir al Login</a>
        </div>
    </div>
</form>

@endsection
