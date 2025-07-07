@extends('app')

@section('content')
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cursos.index') }}">Cursos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Crear Curso</li>
        </ol>
    </nav>

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>Crear Cursos</h1>
                    <button type="button" class="btn btn-secondary btn-sm"
                        onclick="window.location.href='{{ route('cursos.index') }}'">
                        Volver Atrás
                    </button>
                </div>
                <div class="mb-3">
                    <i> Subir un nuevo curso disponible </i>    
                </div>
               

                <form action="{{ route('cursos.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label for="ano" class="form-label">Año</label>
                            <input type="number" class="form-control" id="ano" name="ano"
                                value="ano" min="1" max="7" required>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="division" class="form-label">División</label>
                            <input type="text" class="form-control" id="division" name="division" required>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="turno" class="form-label">Turno</label>
                            <div>
                                <select class="py-2 px-3 form-control" id="turno" name="turno" required>
                                    <option value="" disabled>
                                        Seleccione un turno</option>
                                    <option value="Mañana">
                                        Mañana</option>
                                    <option value="Tarde">
                                        Tarde
                                    </option>
                                    <option value="Vespertino">
                                        Vespertino
                                    </option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="row" id="orientacion-row" style="display: none;">
                        <div class="mb-3 col-md-6">
                            <label for="orientacion" class="form-label">Orientación correspondiente al curso de ciclo
                                superior - (de 4° a 7°)</label>
                            <select class="py-2 px-3 form-control" id="orientacion" name="id_orientacion">
                                <option value="" disabled>
                                    Seleccione una orientación</option>
                                @foreach ($orientaciones as $orientacion)
                                    <option value="{{ $orientacion->id }}">
                                        {{ $orientacion->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Subir Nuevo Curso</button>
                    <a href="{{ route('cursos.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleOrientacion() {
            const ano = document.getElementById('ano').value;
            const orientacionRow = document.getElementById('orientacion-row');
            if (ano >= 4 && ano <= 7) {
                orientacionRow.style.display = '';
            } else {
                orientacionRow.style.display = 'none';
                document.getElementById('orientacion').selectedIndex = 0;
            }
        }
        document.getElementById('ano').addEventListener('input', toggleOrientacion);
        window.addEventListener('DOMContentLoaded', toggleOrientacion);
    </script>
@endsection
