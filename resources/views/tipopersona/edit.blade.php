@extends('app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orientaciones.index') }}">Orientaciones</a></li>
            <li class="breadcrumb-item"><a href="{{ route('programacion.index') }}">Programación</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Editar</h1>
        
    </div>
    <i>Plan de estudio de la orientación de Editar</i>

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-body">
                <h1 class="mb-4">Editar programacion</h1>
                <form action="{{ route('programacion.update', $programacion->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label for="division" class="form-label">División</label>
                            <input type="text" class="form-control" id="division" name="division"
                                value="{{ old('division', $programacion->division) }}" required>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="ano" class="form-label">Año</label>
                            <input type="number" class="form-control" id="ano" name="ano"
                                value="{{ old('ano', $programacion->ano) }}" min="1" max="7" required>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="turno" class="form-label">Turno</label>
                            <div>
                                <select class="py-2 px-3 form-control" id="turno" name="turno" required
                                    style="color: {{ old('turno', $programacion->turno) ? '#212529' : '#6c757d' }};">
                                    <option value="" disabled {{ old('turno', $programacion->turno) ? '' : 'selected' }}>
                                        Seleccione un turno</option>
                                    <option value="Mañana" {{ old('turno', $programacion->turno) == 'Mañana' ? 'selected' : '' }}>
                                        Mañana</option>
                                    <option value="Tarde" {{ old('turno', $programacion->turno) == 'Tarde' ? 'selected' : '' }}>Tarde
                                    </option>
                                    <option value="Vespertino"
                                        {{ old('turno', $programacion->turno) == 'Vespertino' ? 'selected' : '' }}>Vespertino</option>
                                </select>    
                            </div>
                            
                        </div>
                    </div>

                    <div class="row" id="orientacion-row" style="display: none;">
                        <div class="mb-3 col-md-6">
                            <label for="orientacion" class="form-label">Orientación correspondiente al programacion de ciclo superior - (de 4° a 7°)</label>
                            <select class="py-2 px-3 form-control" id="orientacion" name="orientacion_id"
                                style="color: {{ old('orientacion_id', optional($programacion->ciclo_superior)->id_orientaciones) ? '#212529' : '#6c757d' }};">
                                <option value="" disabled
                                    {{ old('orientacion_id', optional($programacion->ciclo_superior)->id_orientaciones) ? '' : 'selected' }}>
                                    Seleccione una orientación</option>
                                @foreach ($orientaciones as $orientacion)
                                    <option value="{{ $orientacion->id }}"
                                        {{ old('orientacion_id', optional($programacion->ciclo_superior)->id_orientaciones) == $orientacion->id ? 'selected' : '' }}>
                                        {{ $orientacion->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar programacion</button>
                                         <a href="{{ route('programacion.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>

@endsection