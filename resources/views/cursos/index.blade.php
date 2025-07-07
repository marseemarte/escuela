{{-- filepath: c:\wamp64\www\escuela\resources\views\cursos\index.blade.php --}}
@extends('app')

@section('content')
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cursos</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Cursos</h1>
        <button type="button" class="btn btn-primary btn-sm mb-3" onclick="window.location.href='{{ route('cursos.create') }}'">
            + Crear Curso 
        </button>
    </div>
    <i> Los cursos que están disponibles en la escuela actualmente </i>     

    <link rel="stylesheet" href="//cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css" />

    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Año</th>
                <th>División</th>
                <th>Turno</th>
                <th>Creado</th>
                <th>Actualizado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cursos as $curso)
                <tr>
                    <td>{{ $curso->id ?? '-' }}</td>
                    <td>{{ $curso->ano ?? '-' }}°</td>
                    <td>{{ $curso->division ?? '-' }}</td>
                    <td>{{ $curso->turno ?? '-' }}</td>
                    <td>{{ $curso->created_at ? $curso->created_at->format('d-m-Y H:i:s') : '-' }}</td>
                    <td>{{ $curso->updated_at ? $curso->updated_at->format('d-m-Y H:i:s') : '-' }}</td>
                    <td>    
                        <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-secondary btn-sm">Editar</a>
                        <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Deshabilitar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No hay cursos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
