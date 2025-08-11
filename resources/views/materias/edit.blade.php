@extends('app')

@section('content')
<div class="container">
    <h1>Editar Materia</h1>

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

    <form action="{{ route('materias.update', $materia) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $materia->nombre) }}" class="form-control" maxlength="70" required>
        </div>

        <div class="form-group mb-3">
            <label for="abreviatura">Abreviatura</label>
            <input type="text" name="abreviatura" value="{{ old('abreviatura', $materia->abreviatura) }}" class="form-control" maxlength="15" required>
        </div>

        <div class="form-group mb-3">
            <label for="estado">Estado</label>
            <select name="estado" class="form-control" required>
                <option value="A" {{ old('estado', $materia->estado) == 'A' ? 'selected' : '' }}>Activo</option>
                <option value="I" {{ old('estado', $materia->estado) == 'I' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="resumen">Resumen</label>
            <textarea name="resumen" class="form-control" maxlength="50" required>{{ old('resumen', $materia->resumen) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('materias.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
