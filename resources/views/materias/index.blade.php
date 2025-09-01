@extends('app')

@section('content')
<div class="container">
    <h1>Listado de Materias</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('materias.create') }}" class="btn btn-primary mb-3">Nueva Materia</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Abreviatura</th>
                <th>Estado</th>
                <th>Resumen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($materias as $materia)
                <tr>
                    <td>{{ $materia->nombre }}</td>
                    <td>{{ $materia->abreviatura }}</td>
                    <td>{{ $materia->estado }}</td>
                    <td>{{ $materia->resumen }}</td>
                    <td>
                        <a href="{{ route('materias.edit', $materia) }}" class="btn btn-sm btn-warning">Editar</a>
{{-- 
                        <form action="{{ route('materias.destroy', $materia) }}" method="POST" style="display:inline-block" onsubmit="return confirm('¿Seguro que querés eliminar esta materia?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                        </form> --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay materias cargadas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
