@extends('app')

@section('content')
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cupof.index') }}">Cupofs</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cupof.show', $cupo->cupof) }}">Cupof {{ $cupo->cupof }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Profesor</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Editar Profesor en Cupof {{ $cupo->cupof }}</h1>
        <a href="{{ route('cupof.show', $cupo->cupof) }}" class="btn btn-secondary btn-sm">
            ← Volver a Revista
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Datos del Profesor</h5>
                </div>
                <div class="card-body">
                    <!-- Información del profesor (solo lectura) -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label"><strong>DNI:</strong></label>
                            <p class="form-control-plaintext">{{ $profesorRevista->dni }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Tipo Usuario:</strong></label>
                            <p class="form-control-plaintext">{{ $profesorRevista->tipo_usuario }}</p>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label"><strong>Nombre:</strong></label>
                            <p class="form-control-plaintext">{{ $profesorRevista->nombre }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Apellido:</strong></label>
                            <p class="form-control-plaintext">{{ $profesorRevista->apellido }}</p>
                        </div>
                    </div>

                    <hr>

                    <!-- Formulario para editar datos de la revista -->
                    <form action="{{ route('cupof.update-profesor', [$cupo->cupof, $profesorRevista->profesor_id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="situacion" class="form-label">Situación <span class="text-danger">*</span></label>
                                <select name="situacion" id="situacion" class="form-select @error('situacion') is-invalid @enderror" required>
                                    <option value="">Seleccionar situación...</option>
                                    <option value="Titular" {{ old('situacion', $profesorRevista->situacion) == 'Titular' ? 'selected' : '' }}>Titular</option>
                                    <option value="Suplente" {{ old('situacion', $profesorRevista->situacion) == 'Suplente' ? 'selected' : '' }}>Suplente</option>
                                    <option value="Interino" {{ old('situacion', $profesorRevista->situacion) == 'Interino' ? 'selected' : '' }}>Interino</option>
                                    <option value="Provisional" {{ old('situacion', $profesorRevista->situacion) == 'Provisional' ? 'selected' : '' }}>Provisional</option>
                                    <option value="Contratado" {{ old('situacion', $profesorRevista->situacion) == 'Contratado' ? 'selected' : '' }}>Contratado</option>
                                </select>
                                @error('situacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="f_desde" class="form-label">Fecha Desde <span class="text-danger">*</span></label>
                                <input type="date" 
                                       name="f_desde" 
                                       id="f_desde" 
                                       class="form-control @error('f_desde') is-invalid @enderror" 
                                       value="{{ old('f_desde', $profesorRevista->f_desde) }}" 
                                       required>
                                @error('f_desde')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="f_hasta" class="form-label">Fecha Hasta</label>
                                <input type="date" 
                                       name="f_hasta" 
                                       id="f_hasta" 
                                       class="form-control @error('f_hasta') is-invalid @enderror" 
                                       value="{{ old('f_hasta', $profesorRevista->f_hasta) }}">
                                @error('f_hasta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Dejar vacío si no tiene fecha de finalización</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('cupof.show', $cupo->cupof) }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Actualizar Profesor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Información del Cupof</h6>
                </div>
                <div class="card-body">
                    <p><strong>Cupof:</strong> {{ $cupo->cupof }}</p>
                    <p><strong>Turno:</strong> {{ $cupo->turno }}</p>
                    <p><strong>Horas:</strong> {{ $cupo->hsmodcar }}</p>
                    <p><strong>Función:</strong> {{ $cupo->funcion }}</p>
                    <p><strong>Cargo:</strong> {{ $cupo->cargo }}</p>
                    <p><strong>Estado:</strong> 
                        @if($cupo->estado == 'h')
                            <span class="badge bg-success">Activo</span>
                        @elseif($cupo->estado == 'd')
                            <span class="badge bg-danger">Inactivo</span>
                        @else
                            <span class="badge bg-secondary">{{ $cupo->estado }}</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Validación de fechas en el frontend
        document.addEventListener('DOMContentLoaded', function() {
            const fechaDesde = document.getElementById('f_desde');
            const fechaHasta = document.getElementById('f_hasta');

            function validarFechas() {
                if (fechaDesde.value && fechaHasta.value) {
                    if (new Date(fechaHasta.value) < new Date(fechaDesde.value)) {
                        fechaHasta.setCustomValidity('La fecha hasta debe ser posterior a la fecha desde');
                    } else {
                        fechaHasta.setCustomValidity('');
                    }
                } else {
                    fechaHasta.setCustomValidity('');
                }
            }

            fechaDesde.addEventListener('change', validarFechas);
            fechaHasta.addEventListener('change', validarFechas);
        });
    </script>
@endsection
