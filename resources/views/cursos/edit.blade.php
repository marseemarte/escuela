{{-- filepath: c:\wamp64\www\escuela\resources\views\cursos\edit.blade.php --}}
@extends('app')

@section('content')
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cursos.index') }}">Cursos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Curso</li>
        </ol>
    </nav>

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-body">
                <h1 class="mb-4">Editar Curso</h1>
                <form action="{{ route('cursos.update', $curso->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label for="division" class="form-label">División</label>
                            <input type="text" class="form-control" id="division" name="division"
                                value="{{ old('division', $curso->division) }}" required>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="ano" class="form-label">Año</label>
                            <input type="number" class="form-control" id="ano" name="ano"
                                value="{{ old('ano', $curso->ano) }}" min="1" max="7" required>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="turno" class="form-label">Turno</label>
                            <div>
                                <select class="py-2 px-3 form-control" id="turno" name="turno" required
                                    style="color: {{ old('turno', $curso->turno) ? '#212529' : '#6c757d' }};">
                                    <option value="" disabled {{ old('turno', $curso->turno) ? '' : 'selected' }}>
                                        Seleccione un turno</option>
                                    <option value="Mañana" {{ old('turno', $curso->turno) == 'Mañana' ? 'selected' : '' }}>
                                        Mañana</option>
                                    <option value="Tarde" {{ old('turno', $curso->turno) == 'Tarde' ? 'selected' : '' }}>Tarde
                                    </option>
                                    <option value="Vespertino"
                                        {{ old('turno', $curso->turno) == 'Vespertino' ? 'selected' : '' }}>Vespertino</option>
                                </select>    
                            </div>
                            
                        </div>
                    </div>

                    <div class="row" id="orientacion-row" style="display: none;">
                        <div class="mb-3 col-md-6">
                            <label for="orientacion" class="form-label">Orientación correspondiente al curso de ciclo superior - (de 4° a 7°)</label>
                            <select class="py-2 px-3 form-control" id="orientacion" name="orientacion_id"
                                style="color: {{ old('orientacion_id', optional($curso->ciclo_superior)->id_orientaciones) ? '#212529' : '#6c757d' }};">
                                <option value="" disabled
                                    {{ old('orientacion_id', optional($curso->ciclo_superior)->id_orientaciones) ? '' : 'selected' }}>
                                    Seleccione una orientación</option>
                                @foreach ($orientaciones as $orientacion)
                                    <option value="{{ $orientacion->id }}"
                                        {{ old('orientacion_id', optional($curso->ciclo_superior)->id_orientaciones) == $orientacion->id ? 'selected' : '' }}>
                                        {{ $orientacion->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar Curso</button>
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
