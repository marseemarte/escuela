@extends('app')

@section('content')
<div class="container">
    <h1>Crear Materia</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Errores:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('materias.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" maxlength="70" required>
        </div>

        <div class="form-group mb-3">
            <label for="abreviatura">Abreviatura</label>
            <input type="text" name="abreviatura" value="{{ old('abreviatura') }}" class="form-control" maxlength="15" required>
        </div>

        <div class="form-group mb-3">
            <label for="estado">Estado</label>
            <select name="estado" class="form-control" required>
                <option value="">-- Seleccionar --</option>
                <option value="A" {{ old('estado') == 'A' ? 'selected' : '' }}>Activo</option>
                <option value="I" {{ old('estado') == 'I' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="resumen">Resumen</label>
            <textarea name="resumen" class="form-control" maxlength="50" required>{{ old('resumen') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="orientacion_id">Orientación</label>
            <select name="orientacion_id" class="form-control" required>
                <option value="">-- Seleccionar Orientación --</option>
                @foreach($orientaciones as $orientacion)
                    <option value="{{ $orientacion->id }}" {{ old('orientacion_id') == $orientacion->id ? 'selected' : '' }}>
                        {{ $orientacion->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="anio">Año</label>
            <select name="anio" class="form-control" required>
                <option value="">-- Seleccionar Año --</option>
                @for($i = 1; $i <= 7; $i++)
                    <option value="{{ $i }}" {{ old('anio') == $i ? 'selected' : '' }}>
                        {{ $i }}° Año
                    </option>
                @endfor
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="tipo">Tipo</label>
            <select name="tipo" class="form-control" required>
                <option value="">-- Seleccionar Tipo --</option>
                <option value="materia" {{ old('tipo') == 'materia' ? 'selected' : '' }}>Materia</option>
                <option value="taller" {{ old('tipo') == 'taller' ? 'selected' : '' }}>Taller</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('materias.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
